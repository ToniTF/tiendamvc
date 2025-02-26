fetch("http://localhost/tiendamvc/api/categories")
.then(data=>data.json())
.then(datos=>{
    datos.forEach(element => {
        let option = document.createElement("option");
        option.value = element.category_id;
        option.textContent = element.name;
        document.getElementById("category").appendChild(option);
        
    });

})
.catch(error=>console.log(error));

fetch("http://localhost/tiendamvc/api/providers")
.then(data=>data.json())
.then(datos=>{
    datos.forEach(element => {
        let option = document.createElement("option");
        option.value = element.provider_id;
        option.textContent = element.name;
        document.getElementById("provider").appendChild(option);
        
    });

})
.catch(error=>console.log(error));