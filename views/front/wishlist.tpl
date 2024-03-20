<h1>Ma Liste d'envie</h1>

{if isset($confirmation)}
    <div class="alert alert-success">{$confirmation}</div>
{/if}

{if empty($products)}
    <p>Votre liste d'envie est vide.</p>
{else}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Image</th>
                <th>Prix TTC</th>
                <th>Quantité</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            {foreach from=$products item=product}
                <tr>
                    <td>{$product.name}</td>
                    <td><img src="{$product.cover.bySize.small_default}" alt="{$product.name}"></td>
                    <td>{$product.price_ttc}</td>
                    <td>{$product.quantity}</td>
                    <td>
                        <form action="{$link->getPageLink('my-account', true)}" method="post">
                            <input type="hidden" name="action" value="remove-from-wishlist">
                            <input type="hidden" name="id_product" value="{$product.id_product}">
                            <input type="hidden" name="id_product_attribute" value="{$product.id_product_attribute}">
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            {/foreach}
        </tbody>
    </table>

    <form action="{$link->getPageLink('cart', true)}" method="post">
        <input type="hidden" name="action" value="add">
        <button type="submit" class="btn btn-primary">Ajouter au panier</button>
    </form>
{/if}