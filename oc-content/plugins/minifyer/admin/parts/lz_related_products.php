<style>
    #related_lz_products {
        width: 100%;
        padding: 15px 0;
    }
    #related_lz_products > h2 {
        font-size: 22px;
        font-weight: 300;
        color: #DA2525;
        border-bottom: 1px solid #eee;
        padding-bottom: 15px;
    }
    #related_lz_products ul {
        display: block;
        padding: 0;
        margin: 0;
        text-align: left;
    }
    #related_lz_products ul li {
        display: inline-block;
        vertical-align: top;
        width: 240px;
        height: 330px;
        margin-right: 20px;
        border: 1px solid #efefef;
        margin-bottom: 40px;
        position: relative;
    }
    #related_lz_products ul li figure img {
        display: block;
        max-width: 100%;
    }
    #related_lz_products ul li h2 {
        font-size: 14px;
        color: #333;
        width: 90%;
        margin: 0 auto;
        font-weight: 300;
    }
    #related_lz_products ul li .btn {
        display: block;
        width: 93%;
        text-align: center;
        background: #DA2525;
        color: #fff;
        padding: 15px 0;
        border-radius: 0 !important;
        margin-bottom: 15px;
        border-color: #DA2525;
        float: none;
        position: absolute;
        bottom: 0;
        left: 3%;
        opacity: 0;
    }
    #related_lz_products ul li:hover .btn {
        opacity: 1;
    }
</style>
<div id="related_lz_products">
    <h2><?php _e('More plugins from Layoutz Web','minify')?></h2>
    <div class="container">
        <ul>

        </ul>
    </div>
</div>
<script>
    $(document).ready(function(){
        setTimeout(function(){
            function renderFusionRow(data){

                var template = '<li>'+
                    '<figure>'+
                    '<img src="{{IMAGE}}"/>'+
                    '</figure>'+
                    '<h2>{{TITLE}}</h2>'+

                    '<a href="{{URL}}" class="btn"><?php _e('Details','minifyer'); ?></a>'+
                    '</li>';

                var row = template
                    .replace('{{IMAGE}}',data[2])
                    .replace('{{TITLE}}',data[4])
                    .replace('{{URL}}',data[1]);

                $('#related_lz_products ul').append(row);
            }
            var api_key = 'AIzaSyDIJMfgL6-oT2o4bJsw3Ui-ilIB-j1QGAQ';
            var fusion_table = '1tMPv-TGtirr0OX1efOdNqy6HM65Z6VX2q0uD5fAb';
            var fusion_url = encodeURI('https://www.googleapis.com/fusiontables/v2/query?sql=SELECT * FROM '+fusion_table+'&key='+api_key);
            $.get(fusion_url, function(data){
                if( data.rows.length ){
                    $.each(data.rows, function(column, row_data){
                        renderFusionRow(row_data);
                    });
                }
            });
        },500);
    });
</script>