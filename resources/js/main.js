var url = 'http://laravelinstagram/';

window.addEventListener('load', function(){

    $('.like').css('cursor','pointer');
    $('.dislike').css('cursor','pointer');

    // NOTE: accion cuando das click en like 
    function like(){
        $('.like').off('click').on("click",function () { 
            var $this = $(this);
            var imageId = $this.data('id');

            $this.addClass('dislike').removeClass('like');
            $this.attr('src',url+'images/hearts-red.png');

            // NOTE: uso de ajax para guardar el like del usuario
            $.ajax({
                type: "GET",
                url: url + 'like/save/' + imageId,
                dataType: "json",
                success: function (response) {
                    if(response.status){
                        $('#image' + imageId).text(response.likes);
                        console.log('has dado like');
                    }else{
                        console.log('error a dar like');
                    }
                }
            });

            dislike();
        });
        
    }

    like();

    // NOTE: accion cuando das click para quitar el like
    function dislike(){
        $('.dislike').off("click").on("click",function () {
            var $this = $(this);
            var imageId = $this.data('id');
            $this.addClass('like').removeClass('dislike');
            $this.attr('src',url+'images/hearts-white.png');


            // NOTE: uso de ajax para guardar el like del usuario
            $.ajax({
                type: "GET",
                url: url + 'like/delete/' + imageId,
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    if(response.status){
                        $('#image' + imageId).text(response.likes);
                        console.log('has dado dislike');
                    }else{
                        console.log('error a dar dislike');
                    }
                }
            });

            like();
        });
    }

    dislike();

    // NOTE: accion para buscar usuario
    $('#form-search').on("submit",function (e) {
        var $this = $(this);
        var inputSearch = $('#search').val();
        $this.attr('action', url + 'profile/list/' + inputSearch);
    });

});
