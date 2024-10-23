document.querySelectorAll('component').forEach(function(component) {
    component.addEventListener('click', function() {
        const action = component.dataset.action;
        const target = component.dataset.target;
        const display = component.dataset.display;

        fetch(`/app/react/action/${action}`, { method: 'GET'})
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro na requisição: ' + response.status);
            }
            return response.json();
        })
        .then(responseData => {
            if(!responseData.message) {
                if(display) {
                    document.getElementById(target).style.display = display;
                }
                document.getElementById(target).innerHTML = responseData;
            }
        })
        .catch(error => {
            console.error('Erro ao fazer a requisição:', error); // Trata erros
        });
    });
});