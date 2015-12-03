/* http://prismjs.com/download.html?themes=prism&languages=markup+css+clike+javascript+php&plugins=line-highlight+line-numbers+autolinker+wpd+show-language */
self = (typeof window !== 'undefined')
    ? window   // if in browser
    : (
    (typeof WorkerGlobalScope !== 'undefined' && self instanceof WorkerGlobalScope)
        ? self // if in worker
        : {}   // if in node js
);

/**
 * Prism: Lightweight, robust, elegant syntax highlighting
 * MIT license http://www.opensource.org/licenses/mit-license.php/
 * @author Lea Verou http://lea.verou.me
 */

var Prism = (function(){

// Private helper vars
    var lang = /\blang(?:uage)?-(?!\*)(\w+)\b/i;

    var _ = self.Prism = {
        util: {
            encode: function (tokens) {
                if (tokens instanceof Token) {
                    return new Token(tokens.type, _.util.encode(tokens.content), tokens.alias);
                } else if (_.util.type(tokens) === 'Array') {
                    return tokens.map(_.util.encode);
                } else {
                    return tokens.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/\u00a0/g, ' ');
                }
            },

            type: function (o) {
                return Object.prototype.toString.call(o).match(/\[object (\w+)\]/)[1];
            },

            // Deep clone a language definition (e.g. to extend it)
            clone: function (o) {
                var type = _.util.type(o);

                switch (type) {
                    case 'Object':
                        var clone = {};

                        for (var key in o) {
                            if (o.hasOwnProperty(key)) {
                                clone[key] = _.util.clone(o[key]);
                            }
                        }

                        return clone;

                    case 'Array':
                        return o.map(function(v) { return _.util.clone(v); });
                }

                return o;
            }
        },

        languages: {
            extend: function (id, redef) {
                var lang = _.util.clone(_.languages[id]);

                for (var key in redef) {
                    lang[key] = redef[key];
                }

                return lang;
            },

            /**
             * Insert a token before another token in a language literal
             * As this needs to recreate the object (we cannot actually insert before keys in object literals),
             * we cannot just provide an object, we need anobject and a key.
             * @param inside The key (or language id) of the parent
             * @param before The key to insert before. If not provided, the function appends instead.
             * @param insert Object with the key/value pairs to insert
             * @param root The object that contains `inside`. If equal to Prism.languages, it can be omitted.
             */
            insertBefore: function (inside, before, insert, root) {
                root = root || _.languages;
                var grammar = root[inside];

                if (arguments.length == 2) {
                    insert = arguments[1];

                    for (var newToken in insert) {
                        if (insert.hasOwnProperty(newToken)) {
                            grammar[newToken] = insert[newToken];
                        }
                    }

                    return grammar;
                }

                var ret = {};

                for (var token in grammar) {

                    if (grammar.hasOwnProperty(token)) {

                        if (token == before) {

                            for (var newToken in insert) {

                                if (insert.hasOwnProperty(newToken)) {
                                    ret[newToken] = insert[newToken];
                                }
                            }
                        }

                        ret[token] = grammar[token];
                    }
                }

                // Update references in other language definitions
                _.languages.DFS(_.languages, function(key, value) {
                    if (value === root[inside] && key != inside) {
                        this[key] = ret;
                    }
                });

                return root[inside] = ret;
            },

            // Traverse a language definition with Depth First Search
            DFS: function(o, callback, type) {
                for (var i in o) {
                    if (o.hasOwnProperty(i)) {
                        callback.call(o, i, o[i], type || i);

                        if (_.util.type(o[i]) === 'Object') {
                            _.languages.DFS(o[i], callback);
                        }
                        else if (_.util.type(o[i]) === 'Array') {
                            _.languages.DFS(o[i], callback, i);
                        }
                    }
                }
            }
        },

        highlightAll: function(async, callback) {
            var elements = document.querySelectorAll('code[class*="language-"], [class*="language-"] code, code[class*="lang-"], [class*="lang-"] code');

            for (var i=0, element; element = elements[i++];) {
                _.highlightElement(element, async === true, callback);
            }
        },

        highlightElement: function(element, async, callback) {
            // Find language
            var language, grammar, parent = element;

            while (parent && !lang.test(parent.className)) {
                parent = parent.parentNode;
            }

            if (parent) {
                language = (parent.className.match(lang) || [,''])[1];
                grammar = _.languages[language];
            }

            if (!grammar) {
                return;
            }

            // Set language on the element, if not present
            element.className = element.className.replace(lang, '').replace(/\s+/g, ' ') + ' language-' + language;

            // Set language on the parent, for styling
            parent = element.parentNode;

            if (/pre/i.test(parent.nodeName)) {
                parent.className = parent.className.replace(lang, '').replace(/\s+/g, ' ') + ' language-' + language;
            }

            var code = element.textContent;

            if(!code) {
                return;
            }

            code = code.replace(/^(?:\r?\n|\r)/,'');

            var env = {
                element: element,
                language: language,
                grammar: grammar,
                code: code
            };

            _.hooks.run('before-highlight', env);

            if (async && self.Worker) {
                var worker = new Worker(_.filename);

                worker.onmessage = function(evt) {
                    env.highlightedCode = Token.stringify(JSON.parse(evt.data), language);

                    _.hooks.run('before-insert', env);

                    env.element.innerHTML = env.highlightedCode;

                    callback && callback.call(env.element);
                    _.hooks.run('after-highlight', env);
                };

                worker.postMessage(JSON.stringify({
                    language: env.language,
                    code: env.code
                }));
            }
            else {
                env.highlightedCode = _.highlight(env.code, env.grammar, env.language);

                _.hooks.run('before-insert', env);

                env.element.innerHTML = env.highlightedCode;

                callback && callback.call(element);

                _.hooks.run('after-highlight', env);
            }
        },

        highlight: function (text, grammar, language) {
            var tokens = _.tokenize(text, grammar);
            return Token.stringify(_.util.encode(tokens), language);
        },

        tokenize: function(text, grammar, language) {
            var Token = _.Token;

            var strarr = [text];

            var rest = grammar.rest;

            if (rest) {
                for (var token in rest) {
                    grammar[token] = rest[token];
                }

                delete grammar.rest;
            }

            tokenloop: for (var token in grammar) {
                if(!grammar.hasOwnProperty(token) || !grammar[token]) {
                    continue;
                }

                var patterns = grammar[token];
                patterns = (_.util.type(patterns) === "Array") ? patterns : [patterns];

                for (var j = 0; j < patterns.length; ++j) {
                    var pattern = patterns[j],
                        inside = pattern.inside,
                        lookbehind = !!pattern.lookbehind,
                        lookbehindLength = 0,
                        alias = pattern.alias;

                    pattern = pattern.pattern || pattern;

                    for (var i=0; i<strarr.length; i++) { // Don’t cache length as it changes during the loop

                        var str = strarr[i];

                        if (strarr.length > text.length) {
                            // Something went terribly wrong, ABORT, ABORT!
                            break tokenloop;
                        }

                        if (str instanceof Token) {
                            continue;
                        }

                        pattern.lastIndex = 0;

                        var match = pattern.exec(str);

                        if (match) {
                            if(lookbehind) {
                                lookbehindLength = match[1].length;
                            }

                            var from = match.index - 1 + lookbehindLength,
                                match = match[0].slice(lookbehindLength),
                                len = match.length,
                                to = from + len,
                                before = str.slice(0, from + 1),
                                after = str.slice(to + 1);

                            var args = [i, 1];

                            if (before) {
                                args.push(before);
                            }

                            var wrapped = new Token(token, inside? _.tokenize(match, inside) : match, alias);

                            args.push(wrapped);

                            if (after) {
                                args.push(after);
                            }

                            Array.prototype.splice.apply(strarr, args);
                        }
                    }
                }
            }

            return strarr;
        },

        hooks: {
            all: {},

            add: function (name, callback) {
                var hooks = _.hooks.all;

                hooks[name] = hooks[name] || [];

                hooks[name].push(callback);
            },

            run: function (name, env) {
                var callbacks = _.hooks.all[name];

                if (!callbacks || !callbacks.length) {
                    return;
                }

                for (var i=0, callback; callback = callbacks[i++];) {
                    callback(env);
                }
            }
        }
    };

    var Token = _.Token = function(type, content, alias) {
        this.type = type;
        this.content = content;
        this.alias = alias;
    };

    Token.stringify = function(o, language, parent) {
        if (typeof o == 'string') {
            return o;
        }

        if (_.util.type(o) === 'Array') {
            return o.map(function(element) {
                return Token.stringify(element, language, o);
            }).join('');
        }

        var env = {
            type: o.type,
            content: Token.stringify(o.content, language, parent),
            tag: 'span',
            classes: ['token', o.type],
            attributes: {},
            language: language,
            parent: parent
        };

        if (env.type == 'comment') {
            env.attributes['spellcheck'] = 'true';
        }

        if (o.alias) {
            var aliases = _.util.type(o.alias) === 'Array' ? o.alias : [o.alias];
            Array.prototype.push.apply(env.classes, aliases);
        }

        _.hooks.run('wrap', env);

        var attributes = '';

        for (var name in env.attributes) {
            attributes += name + '="' + (env.attributes[name] || '') + '"';
        }

        return '<' + env.tag + ' class="' + env.classes.join(' ') + '" ' + attributes + '>' + env.content + '</' + env.tag + '>';

    };

    if (!self.document) {
        if (!self.addEventListener) {
            // in Node.js
            return self.Prism;
        }
        // In worker
        self.addEventListener('message', function(evt) {
            var message = JSON.parse(evt.data),
                lang = message.language,
                code = message.code;

            self.postMessage(JSON.stringify(_.util.encode(_.tokenize(code, _.languages[lang]))));
            self.close();
        }, false);

        return self.Prism;
    }

// Get current script and highlight
    var script = document.getElementsByTagName('script');

    script = script[script.length - 1];

    if (script) {
        _.filename = script.src;

        if (document.addEventListener && !script.hasAttribute('data-manual')) {
            document.addEventListener('DOMContentLoaded', _.highlightAll);
        }
    }

    return self.Prism;

})();

if (typeof module !== 'undefined' && module.exports) {
    module.exports = Prism;
}
;
Prism.languages.markup = {
    'comment': /<!--[\w\W]*?-->/,
    'prolog': /<\?.+?\?>/,
    'doctype': /<!DOCTYPE.+?>/,
    'cdata': /<!\[CDATA\[[\w\W]*?]]>/i,
    'tag': {
        pattern: /<\/?[\w:-]+\s*(?:\s+[\w:-]+(?:=(?:("|')(\\?[\w\W])*?\1|[^\s'">=]+))?\s*)*\/?>/i,
        inside: {
            'tag': {
                pattern: /^<\/?[\w:-]+/i,
                inside: {
                    'punctuation': /^<\/?/,
                    'namespace': /^[\w-]+?:/
                }
            },
            'attr-value': {
                pattern: /=(?:('|")[\w\W]*?(\1)|[^\s>]+)/i,
                inside: {
                    'punctuation': /=|>|"/
                }
            },
            'punctuation': /\/?>/,
            'attr-name': {
                pattern: /[\w:-]+/,
                inside: {
                    'namespace': /^[\w-]+?:/
                }
            }

        }
    },
    'entity': /&#?[\da-z]{1,8};/i
};

// Plugin to make entity title show the real entity, idea by Roman Komarov
Prism.hooks.add('wrap', function(env) {

    if (env.type === 'entity') {
        env.attributes['title'] = env.content.replace(/&amp;/, '&');
    }
});
;
Prism.languages.css = {
    'comment': /\/\*[\w\W]*?\*\//,
    'atrule': {
        pattern: /@[\w-]+?.*?(;|(?=\s*\{))/i,
        inside: {
            'punctuation': /[;:]/
        }
    },
    'url': /url\((?:(["'])(\\\n|\\?.)*?\1|.*?)\)/i,
    'selector': /[^\{\}\s][^\{\};]*(?=\s*\{)/,
    'string': /("|')(\\\n|\\?.)*?\1/,
    'property': /(\b|\B)[\w-]+(?=\s*:)/i,
    'important': /\B!important\b/i,
    'punctuation': /[\{\};:]/,
    'function': /[-a-z0-9]+(?=\()/i
};

if (Prism.languages.markup) {
    Prism.languages.insertBefore('markup', 'tag', {
        'style': {
            pattern: /<style[\w\W]*?>[\w\W]*?<\/style>/i,
            inside: {
                'tag': {
                    pattern: /<style[\w\W]*?>|<\/style>/i,
                    inside: Prism.languages.markup.tag.inside
                },
                rest: Prism.languages.css
            },
            alias: 'language-css'
        }
    });

    Prism.languages.insertBefore('inside', 'attr-value', {
        'style-attr': {
            pattern: /\s*style=("|').*?\1/i,
            inside: {
                'attr-name': {
                    pattern: /^\s*style/i,
                    inside: Prism.languages.markup.tag.inside
                },
                'punctuation': /^\s*=\s*['"]|['"]\s*$/,
                'attr-value': {
                    pattern: /.+/i,
                    inside: Prism.languages.css
                }
            },
            alias: 'language-css'
        }
    }, Prism.languages.markup.tag);
};
Prism.languages.clike = {
    'comment': [
        {
            pattern: /(^|[^\\])\/\*[\w\W]*?\*\//,
            lookbehind: true
        },
        {
            pattern: /(^|[^\\:])\/\/.*/,
            lookbehind: true
        }
    ],
    'string': /("|')(\\\n|\\?.)*?\1/,
    'class-name': {
        pattern: /((?:(?:class|interface|extends|implements|trait|instanceof|new)\s+)|(?:catch\s+\())[a-z0-9_\.\\]+/i,
        lookbehind: true,
        inside: {
            punctuation: /(\.|\\)/
        }
    },
    'keyword': /\b(if|else|while|do|for|return|in|instanceof|function|new|try|throw|catch|finally|null|break|continue)\b/,
    'boolean': /\b(true|false)\b/,
    'function': {
        pattern: /[a-z0-9_]+\(/i,
        inside: {
            punctuation: /\(/
        }
    },
    'number': /\b-?(0x[\dA-Fa-f]+|\d*\.?\d+([Ee]-?\d+)?)\b/,
    'operator': /[-+]{1,2}|!|<=?|>=?|={1,3}|&{1,2}|\|?\||\?|\*|\/|~|\^|%/,
    'ignore': /&(lt|gt|amp);/i,
    'punctuation': /[{}[\];(),.:]/
};
;
Prism.languages.javascript = Prism.languages.extend('clike', {
    'keyword': /\b(break|case|catch|class|const|continue|debugger|default|delete|do|else|enum|export|extends|false|finally|for|function|get|if|implements|import|in|instanceof|interface|let|new|null|package|private|protected|public|return|set|static|super|switch|this|throw|true|try|typeof|var|void|while|with|yield)\b/,
    'number': /\b-?(0x[\dA-Fa-f]+|\d*\.?\d+([Ee][+-]?\d+)?|NaN|-?Infinity)\b/,
    'function': /(?!\d)[a-z0-9_$]+(?=\()/i
});

Prism.languages.insertBefore('javascript', 'keyword', {
    'regex': {
        pattern: /(^|[^/])\/(?!\/)(\[.+?]|\\.|[^/\r\n])+\/[gim]{0,3}(?=\s*($|[\r\n,.;})]))/,
        lookbehind: true
    }
});

if (Prism.languages.markup) {
    Prism.languages.insertBefore('markup', 'tag', {
        'script': {
            pattern: /<script[\w\W]*?>[\w\W]*?<\/script>/i,
            inside: {
                'tag': {
                    pattern: /<script[\w\W]*?>|<\/script>/i,
                    inside: Prism.languages.markup.tag.inside
                },
                rest: Prism.languages.javascript
            },
            alias: 'language-javascript'
        }
    });
}
;
/**
 * Original by Aaron Harun: http://aahacreative.com/2012/07/31/php-syntax-highlighting-prism/
 * Modified by Miles Johnson: http://milesj.me
 *
 * Supports the following:
 * 		- Extends clike syntax
 * 		- Support for PHP 5.3+ (namespaces, traits, generators, etc)
 * 		- Smarter constant and function matching
 *
 * Adds the following new token classes:
 * 		constant, delimiter, variable, function, package
 */

Prism.languages.php = Prism.languages.extend('clike', {
    'keyword': /\b(and|or|xor|array|as|break|case|cfunction|class|const|continue|declare|default|die|do|else|elseif|enddeclare|endfor|endforeach|endif|endswitch|endwhile|extends|for|foreach|function|include|include_once|global|if|new|return|static|switch|use|require|require_once|var|while|abstract|interface|public|implements|private|protected|parent|throw|null|echo|print|trait|namespace|final|yield|goto|instanceof|finally|try|catch)\b/i,
    'constant': /\b[A-Z0-9_]{2,}\b/,
    'comment': {
        pattern: /(^|[^\\])(\/\*[\w\W]*?\*\/|(^|[^:])(\/\/).*?(\r?\n|$))/,
        lookbehind: true
    }
});

// Shell-like comments are matched after strings, because they are less
// common than strings containing hashes...
Prism.languages.insertBefore('php', 'class-name', {
    'shell-comment': {
        pattern: /(^|[^\\])#.*?(\r?\n|$)/,
        lookbehind: true,
        alias: 'comment'
    }
});

Prism.languages.insertBefore('php', 'keyword', {
    'delimiter': /(\?>|<\?php|<\?)/i,
    'variable': /(\$\w+)\b/i,
    'package': {
        pattern: /(\\|namespace\s+|use\s+)[\w\\]+/,
        lookbehind: true,
        inside: {
            punctuation: /\\/
        }
    }
});

// Must be defined after the function pattern
Prism.languages.insertBefore('php', 'operator', {
    'property': {
        pattern: /(->)[\w]+/,
        lookbehind: true
    }
});

// Add HTML support of the markup language exists
if (Prism.languages.markup) {

    // Tokenize all inline PHP blocks that are wrapped in <?php ?>
    // This allows for easy PHP + markup highlighting
    Prism.hooks.add('before-highlight', function(env) {
        if (env.language !== 'php') {
            return;
        }

        env.tokenStack = [];

        env.backupCode = env.code;
        env.code = env.code.replace(/(?:<\?php|<\?)[\w\W]*?(?:\?>)/ig, function(match) {
            env.tokenStack.push(match);

            return '{{{PHP' + env.tokenStack.length + '}}}';
        });
    });

    // Restore env.code for other plugins (e.g. line-numbers)
    Prism.hooks.add('before-insert', function(env) {
        if (env.language === 'php') {
            env.code = env.backupCode;
            delete env.backupCode;
        }
    });

    // Re-insert the tokens after highlighting
    Prism.hooks.add('after-highlight', function(env) {
        if (env.language !== 'php') {
            return;
        }

        for (var i = 0, t; t = env.tokenStack[i]; i++) {
            env.highlightedCode = env.highlightedCode.replace('{{{PHP' + (i + 1) + '}}}', Prism.highlight(t, env.grammar, 'php'));
        }

        env.element.innerHTML = env.highlightedCode;
    });

    // Wrap tokens in classes that are missing them
    Prism.hooks.add('wrap', function(env) {
        if (env.language === 'php' && env.type === 'markup') {
            env.content = env.content.replace(/(\{\{\{PHP[0-9]+\}\}\})/g, "<span class=\"token php\">$1</span>");
        }
    });

    // Add the rules before all others
    Prism.languages.insertBefore('php', 'comment', {
        'markup': {
            pattern: /<[^?]\/?(.*?)>/,
            inside: Prism.languages.markup
        },
        'php': /\{\{\{PHP[0-9]+\}\}\}/
    });
}
;
(function(){

    if(!window.Prism) {
        return;
    }

    function $$(expr, con) {
        return Array.prototype.slice.call((con || document).querySelectorAll(expr));
    }

    function hasClass(element, className) {
        className = " " + className + " ";
        return (" " + element.className + " ").replace(/[\n\t]/g, " ").indexOf(className) > -1
    }

    var CRLF = crlf = /\r?\n|\r/g;

    function highlightLines(pre, lines, classes) {
        var ranges = lines.replace(/\s+/g, '').split(','),
            offset = +pre.getAttribute('data-line-offset') || 0;

        var lineHeight = parseFloat(getComputedStyle(pre).lineHeight);

        for (var i=0, range; range = ranges[i++];) {
            range = range.split('-');

            var start = +range[0],
                end = +range[1] || start;

            var line = document.createElement('div');

            line.textContent = Array(end - start + 2).join(' \r\n');
            line.className = (classes || '') + ' line-highlight';

            //if the line-numbers plugin is enabled, then there is no reason for this plugin to display the line numbers
            if(!hasClass(pre, 'line-numbers')) {
                line.setAttribute('data-start', start);

                if(end > start) {
                    line.setAttribute('data-end', end);
                }
            }

            line.style.top = (start - offset - 1) * lineHeight + 'px';

            //allow this to play nicely with the line-numbers plugin
            if(hasClass(pre, 'line-numbers')) {
                //need to attack to pre as when line-numbers is enabled, the code tag is relatively which screws up the positioning
                pre.appendChild(line);
            } else {
                (pre.querySelector('code') || pre).appendChild(line);
            }
        }
    }

    function applyHash() {
        var hash = location.hash.slice(1);

        // Remove pre-existing temporary lines
        $$('.temporary.line-highlight').forEach(function (line) {
            line.parentNode.removeChild(line);
        });

        var range = (hash.match(/\.([\d,-]+)$/) || [,''])[1];

        if (!range || document.getElementById(hash)) {
            return;
        }

        var id = hash.slice(0, hash.lastIndexOf('.')),
            pre = document.getElementById(id);

        if (!pre) {
            return;
        }

        if (!pre.hasAttribute('data-line')) {
            pre.setAttribute('data-line', '');
        }

        highlightLines(pre, range, 'temporary ');

        document.querySelector('.temporary.line-highlight').scrollIntoView();
    }

    var fakeTimer = 0; // Hack to limit the number of times applyHash() runs

    Prism.hooks.add('after-highlight', function(env) {
        var pre = env.element.parentNode;
        var lines = pre && pre.getAttribute('data-line');

        if (!pre || !lines || !/pre/i.test(pre.nodeName)) {
            return;
        }

        clearTimeout(fakeTimer);

        $$('.line-highlight', pre).forEach(function (line) {
            line.parentNode.removeChild(line);
        });

        highlightLines(pre, lines);

        fakeTimer = setTimeout(applyHash, 1);
    });

    addEventListener('hashchange', applyHash);

})();
;
Prism.hooks.add('after-highlight', function (env) {
    // works only for <code> wrapped inside <pre data-line-numbers> (not inline)
    var pre = env.element.parentNode;
    if (!pre || !/pre/i.test(pre.nodeName) || pre.className.indexOf('line-numbers') === -1) {
        return;
    }

    var linesNum = (1 + env.code.split('\n').length);
    var lineNumbersWrapper;

    var lines = new Array(linesNum);
    lines = lines.join('<span></span>');

    lineNumbersWrapper = document.createElement('span');
    lineNumbersWrapper.className = 'line-numbers-rows';
    lineNumbersWrapper.innerHTML = lines;

    if (pre.hasAttribute('data-start')) {
        pre.style.counterReset = 'linenumber ' + (parseInt(pre.getAttribute('data-start'), 10) - 1);
    }

    env.element.appendChild(lineNumbersWrapper);

});;
(function(){

    if (!self.Prism) {
        return;
    }

    var url = /\b([a-z]{3,7}:\/\/|tel:)[\w\-+%~/.:#=?&amp;]+/,
        email = /\b\S+@[\w.]+[a-z]{2}/,
        linkMd = /\[([^\]]+)]\(([^)]+)\)/,

    // Tokens that may contain URLs and emails
        candidates = ['comment', 'url', 'attr-value', 'string'];

    for (var language in Prism.languages) {
        var tokens = Prism.languages[language];

        Prism.languages.DFS(tokens, function (key, def, type) {
            if (candidates.indexOf(type) > -1 && Prism.util.type(def) !== 'Array') {
                if (!def.pattern) {
                    def = this[key] = {
                        pattern: def
                    };
                }

                def.inside = def.inside || {};

                if (type == 'comment') {
                    def.inside['md-link'] = linkMd;
                }
                if (type == 'attr-value') {
                    Prism.languages.insertBefore('inside', 'punctuation', { 'url-link': url }, def);
                }
                else {
                    def.inside['url-link'] = url;
                }

                def.inside['email-link'] = email;
            }
        });

        tokens['url-link'] = url;
        tokens['email-link'] = email;
    }

    Prism.hooks.add('wrap', function(env) {
        if (/-link$/.test(env.type)) {
            env.tag = 'a';

            var href = env.content;

            if (env.type == 'email-link' && href.indexOf('mailto:') != 0) {
                href = 'mailto:' + href;
            }
            else if (env.type == 'md-link') {
                // Markdown
                var match = env.content.match(linkMd);

                href = match[2];
                env.content = match[1];
            }

            env.attributes.href = href;
        }
    });

})();
;
(function(){

    if (!self.Prism) {
        return;
    }

    if (Prism.languages.css) {
        Prism.languages.css.atrule.inside['atrule-id'] = /^@[\w-]+/;

        // check whether the selector is an advanced pattern before extending it
        if (Prism.languages.css.selector.pattern)
        {
            Prism.languages.css.selector.inside['pseudo-class'] = /:[\w-]+/;
            Prism.languages.css.selector.inside['pseudo-element'] = /::[\w-]+/;
        }
        else
        {
            Prism.languages.css.selector = {
                pattern: Prism.languages.css.selector,
                inside: {
                    'pseudo-class': /:[\w-]+/,
                    'pseudo-element': /::[\w-]+/
                }
            };
        }
    }

    if (Prism.languages.markup) {
        Prism.languages.markup.tag.inside.tag.inside['tag-id'] = /[\w-]+/;

        var Tags = {
            HTML: {
                'a': 1, 'abbr': 1, 'acronym': 1, 'b': 1, 'basefont': 1, 'bdo': 1, 'big': 1, 'blink': 1, 'cite': 1, 'code': 1, 'dfn': 1, 'em': 1, 'kbd': 1,  'i': 1,
                'rp': 1, 'rt': 1, 'ruby': 1, 's': 1, 'samp': 1, 'small': 1, 'spacer': 1, 'strike': 1, 'strong': 1, 'sub': 1, 'sup': 1, 'time': 1, 'tt': 1,  'u': 1,
                'var': 1, 'wbr': 1, 'noframes': 1, 'summary': 1, 'command': 1, 'dt': 1, 'dd': 1, 'figure': 1, 'figcaption': 1, 'center': 1, 'section': 1, 'nav': 1,
                'article': 1, 'aside': 1, 'hgroup': 1, 'header': 1, 'footer': 1, 'address': 1, 'noscript': 1, 'isIndex': 1, 'main': 1, 'mark': 1, 'marquee': 1,
                'meter': 1, 'menu': 1
            },
            SVG: {
                'animateColor': 1, 'animateMotion': 1, 'animateTransform': 1, 'glyph': 1, 'feBlend': 1, 'feColorMatrix': 1, 'feComponentTransfer': 1,
                'feFuncR': 1, 'feFuncG': 1, 'feFuncB': 1, 'feFuncA': 1, 'feComposite': 1, 'feConvolveMatrix': 1, 'feDiffuseLighting': 1, 'feDisplacementMap': 1,
                'feFlood': 1, 'feGaussianBlur': 1, 'feImage': 1, 'feMerge': 1, 'feMergeNode': 1, 'feMorphology': 1, 'feOffset': 1, 'feSpecularLighting': 1,
                'feTile': 1, 'feTurbulence': 1, 'feDistantLight': 1, 'fePointLight': 1, 'feSpotLight': 1, 'linearGradient': 1, 'radialGradient': 1, 'altGlyph': 1,
                'textPath': 1, 'tref': 1, 'altglyph': 1, 'textpath': 1, 'tref': 1, 'altglyphdef': 1, 'altglyphitem': 1, 'clipPath': 1, 'color-profile': 1, 'cursor': 1,
                'font-face': 1, 'font-face-format': 1, 'font-face-name': 1, 'font-face-src': 1, 'font-face-uri': 1, 'foreignObject': 1, 'glyph': 1, 'glyphRef': 1,
                'hkern': 1, 'vkern': 1,
            },
            MathML: {}
        }
    }

    var language;

    Prism.hooks.add('wrap', function(env) {
        if ((['tag-id'].indexOf(env.type) > -1
            || (env.type == 'property' && env.content.indexOf('-') != 0)
            || (env.type == 'atrule-id'&& env.content.indexOf('@-') != 0)
            || (env.type == 'pseudo-class'&& env.content.indexOf(':-') != 0)
            || (env.type == 'pseudo-element'&& env.content.indexOf('::-') != 0)
            || (env.type == 'attr-name' && env.content.indexOf('data-') != 0)
            ) && env.content.indexOf('<') === -1
        ) {
            var searchURL = 'w/index.php?fulltext&search=';

            env.tag = 'a';

            var href = 'http://docs.webplatform.org/';

            if (env.language == 'css') {
                href += 'wiki/css/'

                if (env.type == 'property') {
                    href += 'properties/';
                }
                else if (env.type == 'atrule-id') {
                    href += 'atrules/';
                }
                else if (env.type == 'pseudo-class') {
                    href += 'selectors/pseudo-classes/';
                }
                else if (env.type == 'pseudo-element') {
                    href += 'selectors/pseudo-elements/';
                }
            }
            else if (env.language == 'markup') {
                if (env.type == 'tag-id') {
                    // Check language
                    language = getLanguage(env.content) || language;

                    if (language) {
                        href += 'wiki/' + language + '/elements/';
                    }
                    else {
                        href += searchURL;
                    }
                }
                else if (env.type == 'attr-name') {
                    if (language) {
                        href += 'wiki/' + language + '/attributes/';
                    }
                    else {
                        href += searchURL;
                    }
                }
            }

            href += env.content;

            env.attributes.href = href;
            env.attributes.target = '_blank';
        }
    });

    function getLanguage(tag) {
        var tagL = tag.toLowerCase();

        if (Tags.HTML[tagL]) {
            return 'html';
        }
        else if (Tags.SVG[tag]) {
            return 'svg';
        }
        else if (Tags.MathML[tag]) {
            return 'mathml';
        }

        // Not in dictionary, perform check
        if (Tags.HTML[tagL] !== 0) {
            var htmlInterface = (document.createElement(tag).toString().match(/\[object HTML(.+)Element\]/) || [])[1];

            if (htmlInterface && htmlInterface != 'Unknown') {
                Tags.HTML[tagL] = 1;
                return 'html';
            }
        }

        Tags.HTML[tagL] = 0;

        if (Tags.SVG[tag] !== 0) {
            var svgInterface = (document.createElementNS('http://www.w3.org/2000/svg', tag).toString().match(/\[object SVG(.+)Element\]/) || [])[1];

            if (svgInterface && svgInterface != 'Unknown') {
                Tags.SVG[tag] = 1;
                return 'svg';
            }
        }

        Tags.SVG[tag] = 0;

        // Lame way to detect MathML, but browsers don’t expose interface names there :(
        if (Tags.MathML[tag] !== 0) {
            if (tag.indexOf('m') === 0) {
                Tags.MathML[tag] = 1;
                return 'mathml';
            }
        }

        Tags.MathML[tag] = 0;

        return null;
    }

})();;
(function(){

    if (!self.Prism) {
        return;
    }

    var Languages = {
        'csharp': 'C#',
        'cpp': 'C++'
    };
    Prism.hooks.add('before-highlight', function(env) {
        var pre = env.element.parentNode;
        if (!pre || !/pre/i.test(pre.nodeName)) {
            return;
        }
        var language = Languages[env.language] || env.language;
        pre.setAttribute('data-language', language);
    });

})();
;