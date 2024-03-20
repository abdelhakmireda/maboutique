<form action="{$link->getProductLink($product.id)}" method="post">
    <input type="hidden" name="action" value="add-to-wishlist">
    <input type="hidden" name="id_product" value="{$product.id}">
    <input type="number" name="quantity" value="1" min="1">
    {if isset($product.combinations)}
        <select name="id_product_attribute">
            {foreach from=$product.combinations item=combination}
                <option value="{$combination.id_product_attribute}">{$combination.name}</option>
            {/foreach}
        </select>
    {/if}
    <button type="submit" class="btn btn-primary">Ajouter à la liste d'envie</button>
</form>