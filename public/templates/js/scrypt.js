$(document).ready(function() {

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
      
    // Toast.fire({
    //     icon: 'success',
    //     title: 'Signed in successfully'
    // })

    // Toast.fire({
    //     icon: 'error',
    //     title: 'Signed in successfully'
    // })

    /** 
     * add users
     */
    $(document).on('click', ".sendInfo", function(event) {
        event.preventDefault();
        let datas = [];
        $(".getInfo").each(function() {
            let value = $(this).val();
            let titre = $(this).attr("titre");
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
            url: "/send/mail",
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