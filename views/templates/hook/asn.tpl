<div class="ff-asn">
    <p class="text-uppercase h6 hidden-sm-down">{l s='Filter By' d='Shop.Theme.Actions'}</p>
    <ff-asn align="vertical" unresolved>
        <ff-asn-group class="facet clearfix">
            <ff-asn-group-element>
                <div slot="selected">
                    <span class="custom-checkbox">
                        <input type="checkbox" checked />
                        <span><i class="material-icons rtl-no-flip checkbox-checked">&#xE5CA;</i></span>
                        <span class="filterName">{literal}{{element.name}}{/literal}</span>
                    </span>
                </div>
                <div slot="unselected">
                    <span class="custom-checkbox">
                        <input type="checkbox" />
                        <span><i class="material-icons rtl-no-flip checkbox-checked">&#xE5CA;</i></span>
                        <span class="filterName">{literal}{{element.name}}{/literal}</span>
                    </span>
                </div>
            </ff-asn-group-element>

            <div slot="groupCaption" class="groupCaption" style="padding-bottom: 1px;">
                <p class="h6 facet-title hidden-sm-down">{literal}{{group.name}}{/literal}</p>
            </div>
        </ff-asn-group>
    </ff-asn>
</div>
