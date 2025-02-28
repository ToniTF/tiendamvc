// Confirmar que el script se está ejecutando
console.log('product.js está cargado');

// Cargar categorías en el selector
fetch("http://localhost/tiendamvc/api/categories")
    .then(data => data.json())
    .then(datos => {
        console.log('Categorías cargadas:', datos);
        datos.forEach(element => {
            let option = document.createElement("option");
            option.value = element.category_id;
            option.textContent = element.name;
            document.getElementById("category").appendChild(option);
        });
    })
    .catch(err => {
        console.error("Error al cargar categorías:", err);
    });

// Cargar proveedores en el selector
fetch("http://localhost/tiendamvc/api/providers")
    .then(data => data.json())
    .then(datos => {
        console.log('Proveedores cargados:', datos);
        datos.forEach(element => {
            let option = document.createElement("option");
            option.value = element.provider_id;
            option.textContent = element.name;
            document.getElementById("provider").appendChild(option);
        });
    })
    .catch(err => {
        console.error("Error al cargar proveedores:", err);
    });

// Cargar la lista de productos al iniciar la página
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded - Cargando productos...');
    loadProducts();
});

// Función para cargar productos
function loadProducts() {
    console.log('Ejecutando loadProducts()...');
    fetch("http://localhost/tiendamvc/api/products")
        .then(response => {
            console.log('Respuesta recibida:', response);
            if (!response.ok) {
                throw new Error(`Error HTTP! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Productos recibidos:', data);
            showproducts(data);
        })
        .catch(err => {
            console.error("Error al cargar productos:", err);
        });
}

// Manejar envío del formulario para nuevo producto
document.getElementById("form").onsubmit = function (e) {
    e.preventDefault();
    let product = {
        'name': document.getElementById("name").value,
        'description': document.getElementById("description").value,
        'category_id': document.getElementById("category").value,
        'provider_id': document.getElementById("provider").value,
        'stock': document.getElementById("stock").value,
        'price': document.getElementById("price").value
    };
    
    console.log('Enviando producto:', product);
    
    // Validar los datos antes de enviar
    if (!validateProductData(product)) {
        return; // Detener envío si los datos no son válidos
    }
    
    fetch("http://localhost/tiendamvc/api/newproduct", {
        method: 'POST',
        body: JSON.stringify(product),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`Error HTTP! status: ${response.status}`);
        }
        return response.json();
    })
    .then(datos => {
        console.log('Producto guardado, respuesta:', datos);
        showproducts(datos);
        // Limpiar el formulario después de agregar un producto
        document.getElementById("form").reset();
        // Mostrar mensaje de éxito
        showMessage('Producto agregado correctamente', 'success');
    })
    .catch(error => {
        console.error("Error al guardar producto:", error);
        showMessage('Error al guardar el producto', 'danger');
    });
};

// Función para validar datos de producto
function validateProductData(product) {
    if (!product.name || product.name.trim() === '') {
        showMessage('El nombre del producto es obligatorio', 'warning');
        return false;
    }
    
    if (!product.price || isNaN(parseFloat(product.price)) || parseFloat(product.price) <= 0) {
        showMessage('El precio debe ser un número mayor que cero', 'warning');
        return false;
    }
    
    if (!product.stock || isNaN(parseInt(product.stock)) || parseInt(product.stock) < 0) {
        showMessage('El stock debe ser un número positivo', 'warning');
        return false;
    }
    
    return true;
}

// Función para mostrar mensajes al usuario
function showMessage(message, type) {
    console.log(`Mostrando mensaje: ${message} (${type})`);
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.role = 'alert';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    // Insertar antes del formulario o la tabla
    const container = document.querySelector('.container');
    container.insertBefore(alertDiv, container.firstChild);
    
    // Eliminar automáticamente después de 3 segundos
    setTimeout(() => {
        alertDiv.remove();
    }, 3000);
}

// Función para mostrar los productos en la tabla
function showproducts(datos) {
    console.log('Mostrando productos en la tabla:', datos);
    let tbody = document.getElementById("products");
    tbody.innerHTML = "";
    
    if (!datos || datos.length === 0) {
        // Mostrar mensaje si no hay productos
        const tr = document.createElement("tr");
        const td = document.createElement("td");
        td.colSpan = 8; // Actualizado para incluir la columna de acciones
        td.textContent = "No hay productos disponibles";
        td.className = "text-center";
        tr.appendChild(td);
        tbody.appendChild(tr);
        return;
    }
    
    datos.forEach(element => {
        let tr = document.createElement("tr");
        
        let td = document.createElement("td");
        td.textContent = element.product_id;
        tr.appendChild(td);
        
        td = document.createElement("td");
        td.textContent = element.name;
        tr.appendChild(td);
        
        td = document.createElement("td");
        td.textContent = element.description;
        tr.appendChild(td);
        
        td = document.createElement("td");
        td.textContent = element.category ? element.category.name : 'N/A';
        tr.appendChild(td);
        
        td = document.createElement("td");
        td.textContent = element.provider ? element.provider.name : 'N/A';
        tr.appendChild(td);
        
        td = document.createElement("td");
        td.textContent = element.stock;
        tr.appendChild(td);
        
        td = document.createElement("td");
        td.textContent = `€${parseFloat(element.price).toFixed(2)}`;
        tr.appendChild(td);
        
        // Añadir botones de acción
        td = document.createElement("td");
        td.className = "text-center";
        
        const editBtn = document.createElement("button");
        editBtn.className = "btn btn-sm btn-primary me-1";
        editBtn.innerHTML = '<i class="fas fa-edit"></i>';
        editBtn.title = "Editar";
        editBtn.onclick = () => editProduct(element.product_id);
        td.appendChild(editBtn);
        
        const deleteBtn = document.createElement("button");
        deleteBtn.className = "btn btn-sm btn-danger";
        deleteBtn.innerHTML = '<i class="fas fa-trash"></i>';
        deleteBtn.title = "Eliminar";
        deleteBtn.onclick = () => deleteProduct(element.product_id);
        td.appendChild(deleteBtn);
        
        tr.appendChild(td);
        
        tbody.appendChild(tr);
    });
}

// Función para editar un producto
function editProduct(productId) {
    console.log(`Editando producto ${productId}`);
    window.location.href = `${window.location.origin}/tiendamvc/product/edit/${productId}`;
}

// Función para eliminar un producto
function deleteProduct(productId) {
    if (confirm('¿Está seguro de que desea eliminar este producto?')) {
        console.log(`Eliminando producto ${productId}`);
        fetch(`http://localhost/tiendamvc/api/deleteproduct/${productId}`, {
            method: 'DELETE'
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error HTTP! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Respuesta de eliminación:', data);
            loadProducts();
            showMessage('Producto eliminado correctamente', 'success');
        })
        .catch(error => {
            console.error("Error al eliminar producto:", error);
            showMessage('El producto está asociado a pedidos y no se puede eliminar', 'danger');
        });
    }
}