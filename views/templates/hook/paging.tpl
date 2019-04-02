<div class="ff-paging">
    <ff-paging class="ff-paging" unresolved>
        <ff-paging-set state="currentPage <= 3 && pageCount-currentPage < 3">
            <ff-paging-item type="previousLink">
                <input type="image" class="padd" src="{$ff.img_path}/paging_prev_page.png">
            </ff-paging-item>

            <ff-paging-item type="currentLink -2">{literal}{{caption}}{/literal}</ff-paging-item>
            <ff-paging-item type="currentLink -1">{literal}{{caption}}{/literal}</ff-paging-item>
            <ff-paging-item type="currentLink" style="font-weight: bold;">{literal}{{caption}}{/literal}</ff-paging-item>
            <ff-paging-item type="currentLink +1">{literal}{{caption}}{/literal}</ff-paging-item>
            <ff-paging-item type="currentLink +2">{literal}{{caption}}{/literal}</ff-paging-item>
            <ff-paging-item type="nextLink">
                <input type="image" class="padd" src="{$ff.img_path}/paging_next_page.png">
            </ff-paging-item>
        </ff-paging-set>

        <ff-paging-set state="currentPage <= 3 && pageCount-currentPage >= 3">
            <ff-paging-item type="previousLink">
                <input type="image" class="padd" src="{$ff.img_path}/paging_prev_page.png">
            </ff-paging-item>

            <ff-paging-item type="currentLink -2">{literal}{{caption}}{/literal}</ff-paging-item>
            <ff-paging-item type="currentLink -1">{literal}{{caption}}{/literal}</ff-paging-item>
            <ff-paging-item type="currentLink" style="font-weight: bold;">{literal}{{caption}}{/literal}</ff-paging-item>
            <ff-paging-item type="currentLink +1">{literal}{{caption}}{/literal}</ff-paging-item>
            ...
            <ff-paging-item type="lastLink">{literal}{{caption}}{/literal}</ff-paging-item>
            <ff-paging-item type="nextLink">
                <input type="image" class="padd" src="{$ff.img_path}/paging_next_page.png">
            </ff-paging-item>
        </ff-paging-set>

        <ff-paging-set state="currentPage > 3 && pageCount-currentPage >= 3">
            <ff-paging-item type="previousLink">
                <input type="image" class="padd" src="{$ff.img_path}/paging_prev_page.png">
            </ff-paging-item>

            <ff-paging-item type="firstLink">{literal}{{caption}}{/literal}</ff-paging-item>
            ...
            <ff-paging-item type="currentLink -1">{literal}{{caption}}{/literal}</ff-paging-item>
            <ff-paging-item type="currentLink" style="font-weight: bold;">{literal}{{caption}}{/literal}</ff-paging-item>
            <ff-paging-item type="currentLink +1">{literal}{{caption}}{/literal}</ff-paging-item>
            ...
            <ff-paging-item type="lastLink">{literal}{{caption}}{/literal}</ff-paging-item>

            <ff-paging-item type="nextLink">
                <input type="image" class="padd" src="{$ff.img_path}/paging_next_page.png">
            </ff-paging-item>
        </ff-paging-set>

        <ff-paging-set state="pageCount-currentPage < 3 && currentPage > 3">
            <ff-paging-item type="previousLink">
                <input type="image" class="padd" src="{$ff.img_path}/paging_prev_page.png">
            </ff-paging-item>
            <ff-paging-item type="firstLink">{literal}{{caption}}{/literal}</ff-paging-item>
            ...
            <ff-paging-item type="currentLink -1">{literal}{{caption}}{/literal}</ff-paging-item>
            <ff-paging-item type="currentLink" style="font-weight: bold;">{literal}{{caption}}{/literal}</ff-paging-item>
            <ff-paging-item type="currentLink +1">{literal}{{caption}}{/literal}</ff-paging-item>
            <ff-paging-item type="currentLink +2">{literal}{{caption}}{/literal}</ff-paging-item>

            <ff-paging-item type="nextLink">
                <input type="image" class="padd" src="{$ff.img_path}/paging_next_page.png">
            </ff-paging-item>
        </ff-paging-set>
    </ff-paging>
</div>
