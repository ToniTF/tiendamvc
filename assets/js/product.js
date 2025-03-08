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
    fetch(`${window.location.origin}/tiendamvc/api/products`)
        .then(response => {
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
            // Mostrar mensaje de error en la interfaz
            const tbody = document.getElementById("products");
            if (tbody) {
                tbody.innerHTML = `<tr><td colspan="10" class="text-center text-danger">Error al cargar los productos: ${err.message}</td></tr>`;
            }
        });
}

// Manejar envío del formulario para nuevo producto
document.getElementById("form").onsubmit = function (e) {
    e.preventDefault();
    
    // Obtener los valores del formulario
    const name = document.getElementById("name").value;
    const description = document.getElementById("description").value;
    const category_id = document.getElementById("category").value;
    const provider_id = document.getElementById("provider").value;
    const stock = document.getElementById("stock").value;
    const price = document.getElementById("price").value;
    const cost = document.getElementById("cost").value;  // Campo de coste
    const vat_type = document.getElementById("vat_type").value;  // Campo de IVA
    
    // Crear el objeto con todos los datos
    let product = {
        'name': name,
        'description': description,
        'category_id': category_id,
        'provider_id': provider_id,
        'stock': stock,
        'price': price,
        'cost': cost,  // Incluir el coste
        'vat_type': vat_type  // Incluir el tipo de IVA
    };
    
    console.log('Enviando producto:', product);
    
    // Validar los datos antes de enviar
    if (!validateProductData(product)) {
        return; // Detener envío si los datos no son válidos
    }
    
    // Enviar la solicitud al servidor
    fetch(`${window.location.origin}/tiendamvc/api/newproduct`, {
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
    .then(data => {
        console.log('Respuesta del servidor:', data);
        // Verificar si la respuesta tiene el formato esperado
        if (Array.isArray(data)) {
            // Si es un array, asumimos que son productos
            showproducts(data);
            document.getElementById("form").reset();
            showMessage('Producto guardado correctamente', 'success');
        } else if (data.success === false) {
            // Si hay un mensaje de error
            throw new Error(data.message || 'Error desconocido');
        } else if (data.products && Array.isArray(data.products)) {
            // Si los productos están en data.products
            showproducts(data.products);
            document.getElementById("form").reset();
            showMessage('Producto guardado correctamente', 'success');
        } else {
            throw new Error('Formato de respuesta inesperado');
        }
    })
    .catch(error => {
        console.error("Error:", error);
        showMessage(`Error al guardar el producto: ${error.message}`, 'danger');
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
    
    if (!product.cost || isNaN(parseFloat(product.cost)) || parseFloat(product.cost) < 0) {
        showMessage('El coste debe ser un número positivo o cero', 'warning');
        return false;
    }
    
    if (!product.stock || isNaN(parseInt(product.stock)) || parseInt(product.stock) < 0) {
        showMessage('El stock debe ser un número positivo', 'warning');
        return false;
    }
    
    // Validar que el tipo de IVA sea uno de los valores permitidos
    const allowedVatTypes = [0, 4, 10, 21];
    if (!product.vat_type || !allowedVatTypes.includes(parseInt(product.vat_type))) {
        showMessage('El tipo de IVA debe ser uno de los valores permitidos (0%, 4%, 10%, 21%)', 'warning');
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
    
    // Actualizar el contador de productos
    const countElement = document.getElementById("product-count");
    if (countElement) {
        const count = datos && datos.length ? datos.length : 0;
        countElement.textContent = `${count} producto${count !== 1 ? 's' : ''}`;
    }
    
    if (!datos || datos.length === 0) {
        // Mostrar mensaje si no hay productos
        const tr = document.createElement("tr");
        const td = document.createElement("td");
        td.colSpan = 10; // Para todas las columnas
        td.textContent = "No hay productos disponibles";
        td.className = "text-center p-3";
        tr.appendChild(td);
        tbody.appendChild(tr);
        return;
    }
    
    datos.forEach(element => {
        let tr = document.createElement("tr");
        
        // Columna ID
        let tdId = document.createElement("td");
        tdId.textContent = element.product_id;
        tr.appendChild(tdId);
        
        // Columna Nombre
        let tdName = document.createElement("td");
        tdName.textContent = element.name;
        tr.appendChild(tdName);
        
        // Columna Descripción
        let tdDesc = document.createElement("td");
        tdDesc.textContent = element.description || '-';
        tr.appendChild(tdDesc);
        
        // Columna Categoría
        let tdCategory = document.createElement("td");
        tdCategory.textContent = element.category ? element.category.name : 'N/A';
        tr.appendChild(tdCategory);
        
        // Columna Proveedor
        let tdProvider = document.createElement("td");
        tdProvider.textContent = element.provider ? element.provider.name : 'N/A';
        tr.appendChild(tdProvider);
        
        // Columna Stock
        let tdStock = document.createElement("td");
        tdStock.textContent = element.stock || '0';
        tr.appendChild(tdStock);
        
        // Columna Coste
        let tdCost = document.createElement("td");
        tdCost.textContent = `€${parseFloat(element.cost || 0).toFixed(2)}`;
        tr.appendChild(tdCost);
        
        // Columna IVA
        let tdVat = document.createElement("td");
        tdVat.textContent = `${element.vat_type || 21}%`;
        tr.appendChild(tdVat);
        
        // Columna Precio
        let tdPrice = document.createElement("td");
        tdPrice.textContent = `€${parseFloat(element.price || 0).toFixed(2)}`;
        tr.appendChild(tdPrice);
        
        // Columna Acciones - ÚLTIMA COLUMNA
        let tdActions = document.createElement("td");
        tdActions.className = "text-center"; // Centramos los botones
        
        // Botón Editar
        let btnEdit = document.createElement("button");
        btnEdit.className = "btn btn-sm btn-primary me-2"; // Agregamos margen derecho
        btnEdit.innerHTML = '<i class="fas fa-edit"></i>';
        btnEdit.title = "Editar producto";
        btnEdit.onclick = function() {
            editProduct(element.product_id);
        };
        tdActions.appendChild(btnEdit);
        
        // Botón Eliminar
        let btnDelete = document.createElement("button");
        btnDelete.className = "btn btn-sm btn-danger";
        btnDelete.innerHTML = '<i class="fas fa-trash"></i>';
        btnDelete.title = "Eliminar producto";
        btnDelete.onclick = function() {
            deleteProduct(element.product_id);
        };
        tdActions.appendChild(btnDelete);
        
        // Agregar la celda de acciones a la fila
        tr.appendChild(tdActions);
        
        // Agregar la fila completa a la tabla
        tbody.appendChild(tr);
    });
}

// Función para editar un producto
function editProduct(productId) {
    console.log('Editando producto con ID:', productId);
    // Redirigir a la página de edición
    window.location.href = `http://localhost/tiendamvc/product/edit/${productId}`;
}

// Función para eliminar un producto con confirmación
function deleteProduct(productId) {
    if (!confirm('¿Estás seguro de eliminar este producto?')) {
        return;
    }
    
    fetch(`${window.location.origin}/tiendamvc/api/deleteproduct/${productId}`, {
        method: 'DELETE'
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`Error HTTP! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Respuesta del servidor:', data);
        
        if (data.success === true) {
            showMessage('Producto eliminado correctamente', 'success');
            
            // Verificar dónde están los productos en la respuesta
            if (data.products && Array.isArray(data.products)) {
                showproducts(data.products);
            } else {
                // Si no hay productos en la respuesta, recargar todos
                loadProducts();
            }
        } else {
            throw new Error(data.message || 'Error al eliminar el producto');
        }
    })
    .catch(error => {
        console.error("Error:", error);
        showMessage(`Error al eliminar el producto: ${error.message}`, 'danger');
    });
}

// Función para calcular el margen de beneficio
function calculateMargin(price, cost) {
    const priceValue = parseFloat(price);
    const costValue = parseFloat(cost);
    
    if (isNaN(priceValue) || isNaN(costValue) || costValue === 0) {
        return { margin: 0, percentage: 0 };
    }
    
    const margin = priceValue - costValue;
    const percentage = (margin / costValue) * 100;
    
    return {
        margin: margin.toFixed(2),
        percentage: percentage.toFixed(2)
    };
}

// Función para mostrar detalles del producto incluyendo el margen
function showProductDetail(product) {
    const margin = calculateMargin(product.price, product.cost);
    
    // Crear contenido HTML para el modal o la página de detalle
    const detailHTML = `
        <div class="card">
            <div class="card-header">
                <h5>${product.name}</h5>
            </div>
            <div class="card-body">
                <p>${product.description}</p>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Categoría:</strong> ${product.category ? product.category.name : 'N/A'}</p>
                        <p><strong>Proveedor:</strong> ${product.provider ? product.provider.name : 'N/A'}</p>
                        <p><strong>Stock:</strong> ${product.stock} unidades</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Precio de venta:</strong> €${parseFloat(product.price).toFixed(2)}</p>
                        <p><strong>Coste:</strong> €${parseFloat(product.cost || 0).toFixed(2)}</p>
                        <p><strong>Margen:</strong> €${margin.margin} (${margin.percentage}%)</p>
                        <p><strong>IVA:</strong> ${product.vat_type || 21}%</p>
                        <p><strong>Precio con IVA:</strong> €${(parseFloat(product.price) * (1 + (product.vat_type || 21) / 100)).toFixed(2)}</p>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Insertar el HTML en el contenedor apropiado
    document.getElementById('product-detail-container').innerHTML = detailHTML;
}