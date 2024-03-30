function likeVideo(button, artId){
    $.post("ajax/likeVideo.php",{artId: artId})
    .done(function(data){
        
        
        var likeButton = $(button);

        likeButton.addClass("active");
        

        var result = JSON.parse(data);
        updateLikesValue(likeButton.find(".text"), result.likes);

        if(result.likes < 0){
            likeButton.removeClass("active")
            likeButton.find("img:first").attr("src", "assets/images/icons/thumb-up.png");
        }
        else{
            likeButton.find("img:first").attr("src", "assets/images/icons/thumb-up-active.png");
        }

        

    });
}




function updateLikesValue(element, num){
    var likesCountVal = element.text() || 0;
    element.text(parseInt(likesCountVal) + parseInt(num));
}