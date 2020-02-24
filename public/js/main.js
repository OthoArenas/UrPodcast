var url = 'http://localhost:8888/Maestria/LaboratorioCSW/public';
window.addEventListener("load", function (){
    
    $('.btn-like').css('cursor', 'pointer');
    $('.btn-dislike').css('cursor', 'pointer');

    function like(){
        /* Botón Like */
        $('.btn-like').unbind('click').click(function(){
            console.log('like')
            $(this).addClass('btn-dislike text-danger').removeClass('btn-like text-secondary');

            $.ajax({
                url: url+'/like/'+$(this).data('id'),
                type: 'GET',
                success: function(response){
                    if(response.like){
                        console.log('Has dado like a la publicación');
                        setTimeout(
                            function() 
                            {
                                location.reload();
                            }, 0001); 
                    }else{
                        console.log('Error al dar like');
                    }
                }
            });

            dislike();
        })
    }

    like();

    function dislike(){
        /* Botón Dislike */
        $('.btn-dislike').unbind('click').click(function(){
            console.log('dislike')
            $(this).addClass('btn-like text-secondary').removeClass('btn-dislike text-danger');

             $.ajax({
                url: url+'/dislike/'+$(this).data('id'),
                type: 'GET',
                success: function(response){
                    if(response.like){
                        console.log('Has dado dislike a la publicación');
                        setTimeout(
                            function() 
                            {
                                location.reload();
                            }, 0001); 
                    }else{
                        console.log('Error al dar dislike');
                    }
                }
            });

            like();
        })
    }

    dislike();

});


    
