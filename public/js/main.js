/**
 * Created by ajit on 5/5/16.
 */

function sendParams(){
    this.subCategoryClick = function(){
        $('.sub_category').on('change',function(event){
            $urlObj.generate('subcategory',$(this).val());
        });
    },
    this.brandsClick = function(){
        $('.brands').on('change',function(event){
            $urlObj.generate('brands',$(this).val());
        });
    },
    this.stockClick = function(){
        $('.stock').on('change',function(event){
            $urlObj.generate('stock',$(this).val());
        });
    },
    this.searchClick = function(){
        $('.navbar-form').on('submit',function(e){
            e.preventDefault();
            $urlObj.generate('q',$('#search').val());
        });
    },
    this.priceClick = function(){
        $('#range').on('click',function(){
            if($('#low-price').val() == '' && $('#high-price').val() == '' ){
                return false;
            }

            var price = $('#low-price').val() + 'to' + $('#high-price').val();

            $urlObj.generate('range',price);
        });
    }
}

function urlGenerator(){
    this.generate = function(key, val){
        var params = this.URLToArray(window.location.href);
        if(!(key in params)){
            params[key] = val;
        }else{
            if(key == 'range' || key == 'q'){
                params[key] = val;
            }else {
                var typArr = params[key].split('-');
                var index = typArr.indexOf(val);
                if (index > -1) {
                    typArr.splice(index, 1);
                    params[key] = typArr.join('-');
                } else {
                    if (params[key] == '')
                        params[key] = val;
                    else
                        params[key] += '-' + val;
                }
            }
        }
        if(params){
            var url = this.ArrayToURL(params);
            var url = window.location.href.substring(0, window.location.href.indexOf('?')) + '?' + url;
            //window.location = url;
        }else{
            //window.location = window.location.href.substring(0, window.location.href.indexOf('?'));
            var url = window.location.href.substring(0, window.location.href.indexOf('?'));
        }
        $urlObj.pushState(url);
        $urlObj.ajaxCall(url);
    },
    this.popState = function(){
        history.replaceState({ url:document.location.href }, document.title, document.location.href);

        window.addEventListener('popstate', function(event) {
            $urlObj.ajaxCall(event.state.url);
        });
    },

    this.pushState = function(url){
        history.pushState({
            url:url
        }, '---', url);
    },
    this.ajaxCall = function(url){
        $.ajax({
            url: url,
            data: {
                ajax: '1'
            },
            error: function() {
                alert('<p>An error has occurred</p>');
            },
            success: function(data) {
                $('#content_snippet').replaceWith(data);
                $obj.subCategoryClick();
                $obj.brandsClick();
                $obj.priceClick();
                $obj.stockClick();
                $obj.searchClick();
            },
            type: 'GET'
        });
    },
    this.URLToArray = function(url) {
        var request = {};
        var pairs = {};
        if(url.indexOf('?') !== -1)
            pairs = url.substring(url.indexOf('?') + 1).split('&');

        for (var i = 0; i < pairs.length; i++) {
            if(!pairs[i])
                continue;
            var pair = pairs[i].split('=');
            request[decodeURIComponent(pair[0])] = decodeURIComponent(pair[1]);
        }

        return request;
    },
    this.ArrayToURL = function (array) {
        var pairs = [];
        for (var key in array)
            if (array.hasOwnProperty(key))
                pairs.push(encodeURIComponent(key) + '=' + encodeURIComponent(array[key]));

        return pairs.join('&');
    }
}

$urlObj = new urlGenerator();
$obj = new sendParams();
$obj.subCategoryClick();
$obj.brandsClick();
$obj.priceClick();
$obj.stockClick();
$obj.searchClick();
$urlObj.popState();