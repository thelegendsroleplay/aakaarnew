<?php
/**
 * Template Name: Build Solutions - Smart Wizard
 *
 * Aakaari Smart Solution Builder - 7-step wizard for project configuration.
 */
get_header();
?>
<div class="w-full py-8 md:py-12">
  <div class="container mx-auto px-4">
    <!-- Header Section -->
    <div class="max-w-3xl mx-auto text-center mb-8 md:mb-12">
      <span class="inline-flex items-center justify-center rounded-md border px-3 py-1 text-xs font-medium bg-primary/10 text-primary border-primary/20 mb-4">
        Smart Solution Builder
      </span>
      <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4">Build Your Perfect Solution</h1>
      <p class="text-lg text-muted-foreground max-w-2xl mx-auto">
        Configure your project step by step and get an instant estimate. Our guided wizard helps you choose exactly what you need.
      </p>
    </div>

    <!-- Smart Wizard -->
    <?php echo aakaari_render_smart_wizard(); ?>

    <!-- Trust Indicators -->
    <section class="mt-16 md:mt-24">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
        <div class="text-center p-6">
          <div class="w-12 h-12 mx-auto mb-4 rounded-full bg-green-100 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-600">
              <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path>
              <path d="m9 12 2 2 4-4"></path>
            </svg>
          </div>
          <h3 class="font-semibold mb-2">Secure Process</h3>
          <p class="text-sm text-muted-foreground">Your information is protected with enterprise-grade security</p>
        </div>
        <div class="text-center p-6">
          <div class="w-12 h-12 mx-auto mb-4 rounded-full bg-blue-100 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600">
              <circle cx="12" cy="12" r="10"></circle>
              <polyline points="12 6 12 12 16 14"></polyline>
            </svg>
          </div>
          <h3 class="font-semibold mb-2">Instant Estimates</h3>
          <p class="text-sm text-muted-foreground">Get accurate pricing and timeline as you configure</p>
        </div>
        <div class="text-center p-6">
          <div class="w-12 h-12 mx-auto mb-4 rounded-full bg-purple-100 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-purple-600">
              <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
              <circle cx="12" cy="7" r="4"></circle>
            </svg>
          </div>
          <h3 class="font-semibold mb-2">Expert Support</h3>
          <p class="text-sm text-muted-foreground">Our team is here to help at every step of your project</p>
        </div>
      </div>
    </section>

    <!-- How It Works -->
    <section class="mt-16 md:mt-24 py-12 bg-muted/30 -mx-4 px-4 rounded-2xl">
      <div class="max-w-5xl mx-auto">
        <div class="text-center mb-10">
          <h2 class="text-2xl md:text-3xl font-bold mb-2">How It Works</h2>
          <p class="text-muted-foreground">From configuration to launch in 4 simple steps</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
          <div class="text-center">
            <div class="w-14 h-14 mx-auto mb-4 rounded-full bg-primary text-white flex items-center justify-center text-xl font-bold">1</div>
            <h3 class="font-semibold mb-2">Configure</h3>
            <p class="text-sm text-muted-foreground">Use the wizard to select your project type, features, and preferences</p>
          </div>
          <div class="text-center">
            <div class="w-14 h-14 mx-auto mb-4 rounded-full bg-primary text-white flex items-center justify-center text-xl font-bold">2</div>
            <h3 class="font-semibold mb-2">Review</h3>
            <p class="text-sm text-muted-foreground">See your complete project summary with transparent pricing</p>
          </div>
          <div class="text-center">
            <div class="w-14 h-14 mx-auto mb-4 rounded-full bg-primary text-white flex items-center justify-center text-xl font-bold">3</div>
            <h3 class="font-semibold mb-2">Checkout</h3>
            <p class="text-sm text-muted-foreground">Secure your project with a 50% deposit to begin development</p>
          </div>
          <div class="text-center">
            <div class="w-14 h-14 mx-auto mb-4 rounded-full bg-primary text-white flex items-center justify-center text-xl font-bold">4</div>
            <h3 class="font-semibold mb-2">Launch</h3>
            <p class="text-sm text-muted-foreground">We build your project and deliver on time with full support</p>
          </div>
        </div>
      </div>
    </section>

    <!-- FAQ Section -->
    <section class="mt-16 md:mt-24">
      <div class="max-w-3xl mx-auto">
        <div class="text-center mb-10">
          <h2 class="text-2xl md:text-3xl font-bold mb-2">Frequently Asked Questions</h2>
          <p class="text-muted-foreground">Everything you need to know about our process</p>
        </div>
        <div class="space-y-4">
          <details class="group border rounded-lg">
            <summary class="flex items-center justify-between cursor-pointer p-4 font-medium">
              How accurate are the estimates?
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform group-open:rotate-180">
                <path d="m6 9 6 6 6-6"/>
              </svg>
            </summary>
            <div class="px-4 pb-4 text-muted-foreground">
              Our estimates are based on real project data and are typically accurate within 10-15%. After you complete the wizard, we review your requirements and provide a final fixed quote before any work begins.
            </div>
          </details>
          <details class="group border rounded-lg">
            <summary class="flex items-center justify-between cursor-pointer p-4 font-medium">
              What's included in the price?
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform group-open:rotate-180">
                <path d="m6 9 6 6 6-6"/>
              </svg>
            </summary>
            <div class="px-4 pb-4 text-muted-foreground">
              All prices include design, development, testing, deployment, and 30 days of post-launch support. Hosting and ongoing maintenance are separate and clearly shown in the wizard.
            </div>
          </details>
          <details class="group border rounded-lg">
            <summary class="flex items-center justify-between cursor-pointer p-4 font-medium">
              Can I make changes after placing an order?
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform group-open:rotate-180">
                <path d="m6 9 6 6 6-6"/>
              </svg>
            </summary>
            <div class="px-4 pb-4 text-muted-foreground">
              Yes! We understand requirements evolve. Minor changes are typically accommodated at no extra cost. Larger scope changes can be discussed and quoted separately.
            </div>
          </details>
          <details class="group border rounded-lg">
            <summary class="flex items-center justify-between cursor-pointer p-4 font-medium">
              How do payments work?
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform group-open:rotate-180">
                <path d="m6 9 6 6 6-6"/>
              </svg>
            </summary>
            <div class="px-4 pb-4 text-muted-foreground">
              We require a 50% deposit to begin work, with the remaining 50% due upon project completion before launch. We accept all major credit cards and bank transfers.
            </div>
          </details>
          <details class="group border rounded-lg">
            <summary class="flex items-center justify-between cursor-pointer p-4 font-medium">
              What if I'm not satisfied?
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform group-open:rotate-180">
                <path d="m6 9 6 6 6-6"/>
              </svg>
            </summary>
            <div class="px-4 pb-4 text-muted-foreground">
              Your satisfaction is our priority. We offer unlimited revisions during the design phase and work closely with you throughout development. If you're not happy, we'll make it right.
            </div>
          </details>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="mt-16 md:mt-24">
      <div class="rounded-2xl bg-gradient-to-r from-primary to-blue-600 text-white p-8 md:p-12 text-center">
        <h2 class="text-2xl md:text-3xl font-bold mb-4">Need Help Deciding?</h2>
        <p class="text-lg opacity-90 mb-6 max-w-2xl mx-auto">
          Not sure which options are right for you? Schedule a free consultation and we'll help you configure the perfect solution.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium bg-white text-primary hover:bg-gray-100 h-11 rounded-md px-8 transition-colors">
            Schedule a Call
          </a>
          <a href="mailto:hello@aakaari.com" class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium border border-white text-white hover:bg-white/10 h-11 rounded-md px-8 transition-colors">
            Email Us
          </a>
        </div>
      </div>
    </section>
  </div>
</div>
<?php
get_footer();
?>
