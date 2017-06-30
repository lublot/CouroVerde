window.addEventListener('load',function(){
    var btnFB = document.getElementById('btn-facebook');
    var link = 'https://www.facebook.com/v2.9/dialog/oauth?client_id=1435160229855766&state=83a03b70286ef8249b96f5d7c140ad16&'
                +'response_type=code&sdk=php-sdk-5.5.0&redirect_uri=http%3A%2F%2Flocalhost%2Fsertour%2Flogin%2FacessoFacebook&scope=email';
    btnFB.addEventListener('click',function(){
        console.log('oi');
        window.location.href= link;
    })
});