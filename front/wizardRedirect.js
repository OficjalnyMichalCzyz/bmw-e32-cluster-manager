fetch('http://localhost/api/v1/getButtonMapping')
    .then(function (response) {
        if (response.status === 404) {
            window.location.replace("wizard.html#");
        } else if (response.status === 200) {
            console.log('No wizard needed!')
        }
    })