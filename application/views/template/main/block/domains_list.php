<div class="domains-actions">
	<label><?=I18n::get('search-field-title', $lang)?>:
		<input type="text" ng-model="query" class="search-input" placeholder="<?=I18n::get('search-field-placeholder', $lang)?>" />
	</label>
	<label><?=I18n::get('sort-field-title', $lang)?>: 
		<select ng-model="orderProp" class="search-sort">
			<option value="sdo_name"><?=I18n::get('sort-option-alphabetical', $lang)?></option>
			<option value="-sdo_name"><?=I18n::get('sort-option-alphabetical-reverse', $lang)?></option>
			<option value="price"><?=I18n::get('sort-option-price', $lang)?></option>
			<option value="-price"><?=I18n::get('sort-option-price-reverse', $lang)?></option>
		</select>
	</label>
	
	<br />
	<br />
	
	<input type="text" ng-model="check_name" value="" placeholder="<?=I18n::get('check-name-placeholder', $lang)?>" />
	<input type="button" value="check" ng-click="checkAvailability()" />
</div>

<br /><br />

<div class="domains-list">

		<div class="domain" ng-repeat="domain in domains | filter:query | orderBy:orderProp">
			
			<label>
				<input type="checkbox" checklist-value="domain.sdo_name" checklist-model="user.domains" />
				<span class="domain-attribute name">{{domain.sdo_name}}</span>
				<span class="domain-attribute price">{{domain.price + " " + currency}}</span>
			</label>

		</div>

</div>