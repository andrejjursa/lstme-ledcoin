{extends file='web/layouts/standard.tpl'}
{block content_block}
    <div class="ui-body ui-body-a ui-corner-all">
        <h3>Zoznam tovaru v bufete</h3>
        <p>Súčasný kurz je <strong>1 horalka</strong> za <strong>{include file='web/partials/ledcoin_inflection.tpl' ledcoins={{$multiplier * 1000}|intval / 1000.0}|doubleval inline}</strong><strong title="Kurz je približný.">*</strong>.</p>
        <table data-role="table" data-mode="reflow" class="ui-responsive grid_table">
            <thead>
                <tr>
                    <th data-priority="persist">Obr.</th>
                    <th data-priority="persist">Názov</th>
                    <th data-priority="1">Cena (základná)</th>
                    <th data-priority="1">Cena (prepočítaná)</th>
                    <th data-priority="2">Množstvo skladom</th>
                    <th data-priority="2">Predaných kusov</th>
                </tr>
            </thead>
            <tbody>
                {foreach $products as $product}
                <tr>
                    <td><img src="{get_product_image_min($product->id)}" alt="" /></td>
                    <td>{$product->title}</td>
                    <td>{include file='web/partials/ledcoin_inflection.tpl' ledcoins=$product->price|doubleval inline}</td>
                    <td>{include file='web/partials/ledcoin_inflection.tpl' ledcoins={$product->price * $multiplier}|doubleval inline}</td>
                    <td>{include file='web/partials/pieces_inflection.tpl' pieces={$product->plus_quantity - $product->minus_quantity}|intval inline}</td>
                    <td>{include file='web/partials/pieces_inflection.tpl' pieces=$product->minus_quantity|intval inline}</td>
                </tr>
                {/foreach}
            </tbody>
        </table>
        <p><strong>*</strong> Kurz je približný.</p>
    </div>
{/block}
