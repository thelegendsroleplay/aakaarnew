<?php
get_header();

$checkout = function_exists('WC') ? WC()->checkout() : null;
$cart = function_exists('WC') ? WC()->cart : null;
$cart_empty = !$cart || $cart->is_empty();
$back_url = home_url('/fix-an-issue/');
$back_label = 'Back to Form';
$has_build_solution = false;

if ($cart && !$cart_empty) {
  foreach ($cart->get_cart() as $cart_item) {
    if (!empty($cart_item['aakaari_is_build_solution'])) {
      $has_build_solution = true;
      break;
    }
    if (!empty($cart_item['data']) && is_a($cart_item['data'], 'WC_Product')) {
      if ($cart_item['data']->get_meta('aakaari_is_build_solution') === 'yes') {
        $has_build_solution = true;
        break;
      }
    }
  }
}

if ($has_build_solution) {
  $back_url = home_url('/build-solutions/');
  $back_label = 'Back to Build Solutions';
}

$checkout_subtitle = $has_build_solution ? 'Complete your order and start your build project' : 'Complete your order and get your issue fixed';
$empty_label = $has_build_solution ? 'Return to Build Solutions' : 'Return to Fix an Issue';
?>
<div class="w-full py-12 bg-muted/30">
<div class="container mx-auto px-4">
<a href="<?php echo esc_url($back_url); ?>" data-slot="button" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-all disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg:not([class*='size-'])]:size-4 shrink-0 [&_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive hover:bg-accent hover:text-accent-foreground dark:hover:bg-accent/50 h-9 px-4 py-2 has-[>svg]:px-3 mb-6">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left mr-2 h-4 w-4">
<path d="m12 19-7-7 7-7"></path>
<path d="M19 12H5"></path>
</svg><?php echo esc_html($back_label); ?></a>
<div class="max-w-6xl mx-auto">
<div class="text-center mb-8">
<h1 class="text-3xl md:text-4xl mb-2">Secure Checkout</h1>
<p class="text-muted-foreground"><?php echo esc_html($checkout_subtitle); ?></p>
</div>

<?php if ($cart_empty) : ?>
  <div class="rounded-xl border bg-white p-6 text-center">
    <p class="text-sm text-gray-600 mb-4">Your cart is empty.</p>
    <a href="<?php echo esc_url($back_url); ?>" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-all bg-primary text-primary-foreground hover:bg-primary/90 h-9 px-4 py-2"><?php echo esc_html($empty_label); ?></a>
  </div>
<?php else : ?>
  <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">
    <input type="hidden" name="aakaari_custom_checkout" value="1" />
    <?php wp_nonce_field('woocommerce-process_checkout', 'woocommerce-process-checkout-nonce'); ?>

    <?php do_action('woocommerce_checkout_before_customer_details'); ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <div class="lg:col-span-2 space-y-6">
        <div data-slot="card" class="bg-card text-card-foreground flex flex-col gap-6 rounded-xl border">
          <div data-slot="card-header" class="@container/card-header grid auto-rows-min grid-rows-[auto_auto] items-start gap-1.5 px-6 pt-6 has-data-[slot=card-action]:grid-cols-[1fr_auto] [.border-b]:pb-6">
            <h4 data-slot="card-title" class="leading-none">Contact Information</h4>
            <p data-slot="card-description" class="text-muted-foreground">We'll send order confirmation to this email</p>
          </div>
          <div data-slot="card-content" class="px-6 [&:last-child]:pb-6 space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <?php
                if ($checkout) {
                  woocommerce_form_field('billing_first_name', $checkout->get_checkout_fields('billing')['billing_first_name'], $checkout->get_value('billing_first_name'));
                  woocommerce_form_field('billing_last_name', $checkout->get_checkout_fields('billing')['billing_last_name'], $checkout->get_value('billing_last_name'));
                }
              ?>
            </div>
            <?php
              if ($checkout) {
                woocommerce_form_field('billing_email', $checkout->get_checkout_fields('billing')['billing_email'], $checkout->get_value('billing_email'));
                woocommerce_form_field('billing_phone', $checkout->get_checkout_fields('billing')['billing_phone'], $checkout->get_value('billing_phone'));
              }
            ?>
          </div>
        </div>

        <div data-slot="card" class="bg-card text-card-foreground flex flex-col gap-6 rounded-xl border">
          <div data-slot="card-header" class="@container/card-header grid auto-rows-min grid-rows-[auto_auto] items-start gap-1.5 px-6 pt-6 has-data-[slot=card-action]:grid-cols-[1fr_auto] [.border-b]:pb-6">
            <h4 data-slot="card-title" class="leading-none">Billing Address</h4>
          </div>
          <div data-slot="card-content" class="px-6 [&:last-child]:pb-6 space-y-4">
            <?php
              if ($checkout) {
                woocommerce_form_field('billing_country', $checkout->get_checkout_fields('billing')['billing_country'], $checkout->get_value('billing_country'));
                woocommerce_form_field('billing_address_1', $checkout->get_checkout_fields('billing')['billing_address_1'], $checkout->get_value('billing_address_1'));
              }
            ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <?php
                if ($checkout) {
                  woocommerce_form_field('billing_city', $checkout->get_checkout_fields('billing')['billing_city'], $checkout->get_value('billing_city'));
                  woocommerce_form_field('billing_postcode', $checkout->get_checkout_fields('billing')['billing_postcode'], $checkout->get_value('billing_postcode'));
                }
              ?>
            </div>
            <?php
              if ($checkout && isset($checkout->get_checkout_fields('billing')['billing_state'])) {
                woocommerce_form_field('billing_state', $checkout->get_checkout_fields('billing')['billing_state'], $checkout->get_value('billing_state'));
              }
            ?>
          </div>
        </div>

        <div data-slot="card" class="bg-card text-card-foreground flex flex-col gap-6 rounded-xl border">
          <div data-slot="card-header" class="@container/card-header grid auto-rows-min grid-rows-[auto_auto] items-start gap-1.5 px-6 pt-6 has-data-[slot=card-action]:grid-cols-[1fr_auto] [.border-b]:pb-6">
            <h4 data-slot="card-title" class="leading-none">Payment Method</h4>
            <p data-slot="card-description" class="text-muted-foreground">Choose how you'd like to pay</p>
          </div>
          <div data-slot="card-content" class="px-6 [&:last-child]:pb-6 space-y-6">
            <div id="payment" class="woocommerce-checkout-payment">
              <?php echo function_exists('aakaari_build_render_payment_methods') ? aakaari_build_render_payment_methods() : ''; ?>
            </div>
          </div>
        </div>
      </div>

      <div class="lg:col-span-1">
        <div data-slot="card" class="bg-card text-card-foreground flex flex-col gap-6 rounded-xl border sticky top-24">
          <div data-slot="card-header" class="@container/card-header grid auto-rows-min grid-rows-[auto_auto] items-start gap-1.5 px-6 pt-6 has-data-[slot=card-action]:grid-cols-[1fr_auto] [.border-b]:pb-6">
            <h4 data-slot="card-title" class="leading-none">Order Summary</h4>
          </div>
          <div data-slot="card-content" class="px-6 [&:last-child]:pb-6 space-y-4">
            <?php do_action('woocommerce_checkout_before_order_review'); ?>
            <div id="order_review" class="woocommerce-checkout-review-order">
              <?php echo function_exists('aakaari_build_render_order_review') ? aakaari_build_render_order_review() : ''; ?>
            </div>
            <?php do_action('woocommerce_checkout_after_order_review'); ?>

            <div>
              <label class="items-center gap-2 font-medium select-none text-sm mb-2 block" for="aakaari-coupon">Have a coupon?</label>
              <div class="flex gap-2">
                <input data-aakaari-coupon id="aakaari-coupon" class="file:text-foreground placeholder:text-muted-foreground selection:bg-primary selection:text-primary-foreground dark:bg-input/30 border-input flex h-9 w-full min-w-0 rounded-md border px-3 py-1 text-base bg-input-background transition-[color,box-shadow] outline-none" placeholder="Enter code" />
                <button data-aakaari-apply-coupon class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-all disabled:pointer-events-none disabled:opacity-50 border bg-background text-foreground hover:bg-accent hover:text-accent-foreground h-9 px-4 py-2" type="button">Apply</button>
              </div>
              <p data-aakaari-coupon-notice class="hidden text-xs mt-2"></p>
            </div>

            <div class="bg-muted/50 p-4 rounded-lg space-y-2">
              <div class="flex items-center text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-check h-4 w-4 text-green-600 mr-2"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path><path d="m9 12 2 2 4-4"></path></svg>
                <span>Secure payment processing</span>
              </div>
              <div class="flex items-center text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-lock h-4 w-4 text-green-600 mr-2"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                <span>256-bit SSL encryption</span>
              </div>
            </div>

            <?php
              $total = $cart ? $cart->get_total('edit') : 0;
              $total_label = function_exists('wc_price') ? wp_strip_all_tags(wc_price($total)) : '$' . number_format_i18n($total, 2);
            ?>
            <button type="submit" class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium transition-all disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 rounded-md px-6 w-full" name="woocommerce_checkout_place_order" id="place_order" value="place_order">
              Pay <?php echo esc_html($total_label); ?>
            </button>
            <p class="text-xs text-center text-muted-foreground">Your payment information is secure and encrypted</p>
          </div>
        </div>
      </div>
    </div>

    <?php do_action('woocommerce_checkout_after_customer_details'); ?>
  </form>
<?php endif; ?>
</div>
</div>
</div>
<?php
get_footer();
?>
