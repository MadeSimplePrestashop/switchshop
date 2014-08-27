<!-- Block Switch Shop module -->
<div id="shops_block_top_separator">
    <div class="current_separator">
        <span class="cur-label">{l s='Store' mod='shopswitch'}:</span>
        {foreach from=$shops  item=shop name=switchshop}
            <a {if $shop.id_shop == $current_shop_id}class="selected"{/if} href="{$uri_protocol}{$shop.domain}{$shop.uri}" title="{$shop.name}">
                {$shop.name}
            </a>
            <span class="separator">
                {if $smarty.foreach.switchshop.last==false}
                    {$separator}
                {/if}
            </span>
            {/foreach}
    </div>
</div>
<style type="text/css">
    #shops_block_top_separator {
        float: right;
        border-left: 1px solid #515151;
        position: relative; }
    @media (max-width: 479px) {
        #shops_block {
            width: 25%; } }
    #shops_block_top_separator div.current_separator a,#shops_block_top_separator div.current_separator span {
        float:left;
        font-weight: bold;
        padding: 8px 10px 10px 10px;
        color: #aaa;
        text-shadow: 1px 1px rgba(0, 0, 0, 0.2);
        cursor: pointer;
        line-height: 18px; 
        display:inline-block;
    }
    #shops_block_top_separator div.current_separator .separator { padding-left:0; padding-right:0; }
    
    @media (max-width: 479px) {
        #shops_block_top_separator div.current_separator {
            text-align: center;
            padding: 9px 5px 10px;
            font-size: 11px; } }
    #shops_block_top_separator div.current_separator a:hover,#shops_block_top_separator div.current_separator a.selected { background: #2b2b2b;  color: #fff;}

</style>
