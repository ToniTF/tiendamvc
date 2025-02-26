fetch("http://localhost/tiendamvc/api/categories")
.then(data=>data.json())
.then(datos=>{
    console.log(datos);

})
.catch(error=>console.log(error));