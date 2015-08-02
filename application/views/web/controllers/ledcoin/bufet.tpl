{extends file='web/layouts/standard.tpl'}
{block content_block}
    <div class="ui-body ui-body-a ui-corner-all">
        <h3>Zoznam tovaru v bufete</h3>
        <table data-role="table" data-mode="reflow" class="ui-responsive grid_table">
            <thead>
                <tr>
                    <th data-priority="persist">Obr.</th>
                    <th data-priority="persist">Názov</th>
                    <th data-priority="1">Cena</th>
                    <th data-priority="2">Množstvo skladom</th>
                    <th data-priority="2">Predaných kusov</th>
                </tr>
            </thead>
            <tbody>
                {foreach $products as $product}
                <tr>
                    <td><img src="{get_product_image_min($product->id)}" alt="" /></td>
                    <td>{$product->title}</td>
                    <td>{include file='web/partials/ledcoin_inflection.tpl' ledcoins=$product->price inline}</td>
                    <td>{include file='web/partials/pieces_inflection.tpl' pieces={$product->plus_quantity - $product->minus_quantity}|intval inline}</td>
                    <td>{include file='web/partials/pieces_inflection.tpl' pieces=$product->minus_quantity|intval inline}</td>
                </tr>
                {/foreach}
            </tbody>
        </table>
    </div>
{/block}