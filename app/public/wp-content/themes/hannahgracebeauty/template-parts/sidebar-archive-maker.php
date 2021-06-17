<?php
/*
@package: wwd blankslate
*/
$selected_audiences = isset($_GET["maker_audience"]) ? explode(",", $_GET["maker_audience"]) : [];
$selected_products = isset($_GET["maker_product"]) ? explode(",", $_GET["maker_product"]) : [];
$audiences = get_terms('maker_audience');
$products = get_terms('maker_product');
?>

<section class="product-search-container">
	<form id="productsearch" action="/maker/" method="get">
		<div id="search-audiences">
			<h6>Target Audience</h6>
            <div class="search-filters">
<?php
	foreach($audiences as $audience):
?>
	<label for="<?php echo "chk" . $audience->name; ?>">
		<input type="checkbox" id="<?php echo "chk" . $audience->name; ?>"
            class="manufacturer" 
            value="<?php echo esc_html($audience->slug); ?>"
			<?php echo in_array($audience->slug, $selected_audiences) ? "checked='checked'" : ''; ?>>
		<?php echo $audience->name; ?>
	</label>
<?php
	endforeach;
?>
            </div>
		</div>
		<div id="search-products">
			<h6>What They Make</h6>
            <div class="search-filters">
<?php
    foreach($products as $product):
?>
	<label for="<?php echo "chk" . $product->name; ?>">
		<input type="checkbox" id="<?php echo "chk" . $product->name; ?>" class="category" 
            value="<?php echo esc_html($product->slug); ?>"
			<?php echo in_array($product->slug, $selected_products) ? "checked='checked'" : ''; ?>>
		<?php echo $product->name; ?>
	</label>
<?php
	endforeach;
?>
            </div>
		</div>
		<div class="controls">
			<button id="product-search" type="submit" class="md-btn btn-block">Search</button>
		</div>

		<input type="hidden" id="maker_audience" name="maker_audience"
			value="<?php echo $_GET["maker_audience"]; ?>" />
		<input type="hidden" id="maker_product" name="maker_product" 
			value="<?php echo $_GET["maker_product"]; ?>" />
	</form>
</section>