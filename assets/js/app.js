fetch("api/fetch_products.php")
    .then(res => res.json())
    .then(data => {
        let html = "";
        data.forEach(p => {
            html += `
        <div class="product-card">
            <h3>${p.product_name}</h3>
            <p>Category: ${p.category_name}</p>
            <p>Price: $${p.price}</p>
            <p>${p.description}</p>
        </div>`;
        });
        document.getElementById("products").innerHTML = html;
    });