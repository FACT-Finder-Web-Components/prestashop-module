<div class="search-wrapper search-widget">
    <form class="top-search-box" onsubmit="return false">
        <ff-searchbox class="ff-searchbox" suggest-onfocus="true" use-suggest="true" select-onclick="true">
            <input type="text" placeholder="{l s='Search our catalog' d='Shop.Theme.Catalog'}" aria-label="{l s='Search' d='Shop.Theme.Catalog'}" />
        </ff-searchbox>

        <ff-searchbutton>
            <button type="submit">
                <i class="material-icons search">&#xE8B6;</i>
                <span class="hidden-xl-down">{l s='Search' d='Shop.Theme.Catalog'}</span>
            </button>
        </ff-searchbutton>
    </form>

    {if $ff.suggest && $page.page_name neq 'module-factfinder-search'}{widget name="factfinder" hook="suggest"}{/if}
</div>
