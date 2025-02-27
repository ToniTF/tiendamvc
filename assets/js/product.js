fetch("http://localhost/tiendamvc/api/categories")
    .then(data => data.json())
    .then(datos => {
        datos.forEach(element => {
            let option = document.createElement("option");
            option.value = element.category_id;
            option.textContent = element.name;
            document.getElementById("category").appendChild(option);
        });
    })
    .catch(err => {
        console.log(err);
    })

fetch("http://localhost/tiendamvc/api/providers")
    .then(data => data.json())
    .then(datos => {
        datos.forEach(element => {
            let option = document.createElement("option");
            option.value = element.provider_id;
            option.textContent = element.name;
            document.getElementById("provider").appendChild(option);
        });
    })
    .catch(err => {
        console.log(err);
    })

document.getElementById("form").onsubmit = function (e) {
    e.preventDefault();
    let product={
        'name': document.getElementById("name").value,
        'description':document.getElementById("description").value,
        'category_id':document.getElementById("category").value,
        'provider_id':document.getElementById("provider").value,
        'stock':document.getElementById("stock").value,
        'price':document.getElementById("price").value
    }
    //ToDO: Validar los datos
    fetch("http://localhost/tiendamvc/api/newproduct",{
        method: 'POST',
        body: JSON.stringify(product),
        headers:{
            'Content-Type': 'application/x-www-form-urlencoded'
        }
    })
    .then(data => data.json())
    .then(datos => {
        if(datos.status==200){
            alert("Producto registrado correctamente");
        }else{
            alert("Error al registrar el producto");
        }
    })
}