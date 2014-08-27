<!-- Block Switch Shop module -->
<div id="shops_block_top">
    <div class="current">
        <span class="cur-label">{l s='Store' mod='shopswitch'}:</span>
        {foreach from=$shops item=shop}
            {if $shop.id_shop == $current_shop_id}<strong>{$shop.name}</strong>{/if}
        {/foreach}
    </div>
    <ul class="toogle_content">
        {foreach from=$shops  item=shop}
            <li {if $shop.id_shop == $current_shop_id}class="selected"{/if}>
                <a href="{$uri_protocol}{$shop.domain}{$shop.uri}" title="{$shop.name}">
                    {$shop.name}
                </a>
            </li>
        {/foreach}
    </ul>
</div>
<style type="text/css">
    #shops_block_top {
        float: right;
        border-left: 1px solid #515151;
        position: relative; }
    @media (max-width: 479px) {
        #shops_block {
            width: 25%; } }
    #shops_block_top div.current {
        font-weight: bold;
        padding: 8px 10px 10px 10px;
        color: white;
        text-shadow: 1px 1px rgba(0, 0, 0, 0.2);
        cursor: pointer;
        line-height: 18px; }
    @media (max-width: 479px) {
        #shops_block_top div.current {
            text-align: center;
            padding: 9px 5px 10px;
            font-size: 11px; } }
    #shops_block_top div.current strong {
        color: #777777; }
    #shops_block_top div.current:hover, #shops_block_top div.current.active {
        background: #2b2b2b; }
    #shops_block_top div.current:after {
        content: "\f0d7";
        font-family: "FontAwesome";
        font-size: 18px;
        line-height: 18px;
        color: #686666;
        vertical-align: -2px;
        padding-left: 12px; }
    @media (max-width: 479px) {
        #shops_block_top div.current:after {
            padding-left: 2px;
            font-size: 13px;
            line-height: 13px;
            vertical-align: 0; } }
    @media (max-width: 479px) {
        #shops_block_top div.current .cur-label {
            display: none; } }
    #shops_block_top ul {
        display: none;
        position: absolute;
        top: 37px;
        left: 0;
        width: 157px;
        background: #333333;
        z-index: 2; }
    #shops_block_top ul li {
        color: white;
        line-height: 35px;
        font-size: 13px; }
    #shops_block_top ul li a,
    #shops_block_top ul li > span {
        padding: 0 10px 0 12px;
        display: block;
        color: white; }
    #shops_block_top ul li.selected, #shops_block_top ul li:hover a {
        background: #484848; }


</style>
<!-- /Block currencies module -->
