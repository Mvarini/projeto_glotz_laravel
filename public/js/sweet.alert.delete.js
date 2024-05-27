// Receber o seletor apagar e percorrer a lista de registro
document.querySelectorAll('.btnDelete').forEach(function (button){

    // Aguardar o clique do usuário no botão apagar
    button.addEventListener('click', function (event){

        // Bloquear o recarregamento da página
        event.preventDefault()

        // Receber o atributo que possui o id do registro que deve ser excluído
        var deleteId = this.getAttribute('data-delete-id')

        // SwweAlert
        Swal.fire({
            title: "Tem certeza?",
            text: "Você não poderá reverter isso!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#0d6efd",
            confirmButtonText: "Sim, excluir!",
            cancelButtonColor: "#dc3545",
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`formDelete${deleteId}`).submit();
            }
        });
    })
})
