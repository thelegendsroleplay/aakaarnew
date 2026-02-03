<?php
get_header('minimal');
?>
<div class="min-h-screen pt-24 pb-20 px-4 bg-gradient-to-b from-gray-50 to-white">
<div class="container mx-auto max-w-md">
<div class="text-center mb-8">
<div class="flex items-center justify-center space-x-2 mb-6">
<div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-blue-600 to-blue-500 shadow-lg shadow-blue-500/30">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sparkles h-6 w-6 text-white">
<path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z">
</path>
<path d="M20 3v4">
</path>
<path d="M22 5h-4">
</path>
<path d="M4 17v2">
</path>
<path d="M5 18H3">
</path>
</svg>
</div>
<span class="text-2xl font-bold text-gray-900">Aakaari</span>
</div>
<h1 class="text-3xl font-bold mb-2 text-gray-900">Welcome Back</h1>
<p class="text-gray-600">Sign in to manage your website fixes</p>
</div>
<div data-slot="card" class="bg-card text-card-foreground flex flex-col gap-6 rounded-xl p-8 border-2 border-gray-200">
<div dir="ltr" data-orientation="horizontal" data-slot="tabs" class="flex flex-col gap-2 w-full">
<div role="tablist" aria-orientation="horizontal" data-slot="tabs-list" class="bg-muted text-muted-foreground h-9 items-center justify-center rounded-xl p-[3px] grid w-full grid-cols-2 mb-8" tabindex="-1" data-orientation="horizontal" style="outline:none">
<button type="button" role="tab" aria-selected="true" aria-controls="radix-:R2:-content-login" data-state="active" id="radix-:R2:-trigger-login" data-slot="tabs-trigger" class="data-[state=active]:bg-card dark:data-[state=active]:text-foreground focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:outline-ring dark:data-[state=active]:border-input dark:data-[state=active]:bg-input/30 text-foreground dark:text-muted-foreground inline-flex h-[calc(100%-1px)] flex-1 items-center justify-center gap-1.5 rounded-xl border border-transparent px-2 py-1 text-sm font-medium whitespace-nowrap transition-[color,box-shadow] focus-visible:ring-[3px] focus-visible:outline-1 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#x27;size-&#x27;])]:size-4" tabindex="-1" data-orientation="horizontal" data-radix-collection-item="">Login</button>
<button type="button" role="tab" aria-selected="false" aria-controls="radix-:R2:-content-signup" data-state="inactive" id="radix-:R2:-trigger-signup" data-slot="tabs-trigger" class="data-[state=active]:bg-card dark:data-[state=active]:text-foreground focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:outline-ring dark:data-[state=active]:border-input dark:data-[state=active]:bg-input/30 text-foreground dark:text-muted-foreground inline-flex h-[calc(100%-1px)] flex-1 items-center justify-center gap-1.5 rounded-xl border border-transparent px-2 py-1 text-sm font-medium whitespace-nowrap transition-[color,box-shadow] focus-visible:ring-[3px] focus-visible:outline-1 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#x27;size-&#x27;])]:size-4" tabindex="-1" data-orientation="horizontal" data-radix-collection-item="">Sign Up</button>
</div>
<div data-state="active" data-orientation="horizontal" role="tabpanel" aria-labelledby="radix-:R2:-trigger-login" id="radix-:R2:-content-login" tabindex="0" data-slot="tabs-content" class="flex-1 outline-none" style="animation-duration:0s">
<form class="space-y-6">
<div class="space-y-2">
<label data-slot="label" class="flex items-center gap-2 text-sm leading-none font-medium select-none group-data-[disabled=true]:pointer-events-none group-data-[disabled=true]:opacity-50 peer-disabled:cursor-not-allowed peer-disabled:opacity-50" for="login-email">Email Address</label>
<div class="relative">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-400">
<rect width="20" height="16" x="2" y="4" rx="2">
</rect>
<path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7">
</path>
</svg>
<input type="email" data-slot="input" class="file:text-foreground placeholder:text-muted-foreground selection:bg-primary selection:text-primary-foreground dark:bg-input/30 flex h-9 w-full min-w-0 rounded-md border px-3 py-1 text-base bg-input-background transition-[color,box-shadow] outline-none file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive pl-10 border-gray-300" id="login-email" placeholder="you@example.com" required="" value=""/>
</div>
</div>
<div class="space-y-2">
<label data-slot="label" class="flex items-center gap-2 text-sm leading-none font-medium select-none group-data-[disabled=true]:pointer-events-none group-data-[disabled=true]:opacity-50 peer-disabled:cursor-not-allowed peer-disabled:opacity-50" for="login-password">Password</label>
<div class="relative">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-lock absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-400">
<rect width="18" height="11" x="3" y="11" rx="2" ry="2">
</rect>
<path d="M7 11V7a5 5 0 0 1 10 0v4">
</path>
</svg>
<input type="password" data-slot="input" class="file:text-foreground placeholder:text-muted-foreground selection:bg-primary selection:text-primary-foreground dark:bg-input/30 flex h-9 w-full min-w-0 rounded-md border px-3 py-1 text-base bg-input-background transition-[color,box-shadow] outline-none file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive pl-10 border-gray-300" id="login-password" placeholder="••••••••" required="" value=""/>
</div>
</div>
<div class="flex items-center justify-between">
<div class="flex items-center space-x-2">
<button type="button" role="checkbox" aria-checked="false" data-state="unchecked" value="on" data-slot="checkbox" class="peer bg-input-background dark:bg-input/30 data-[state=checked]:bg-primary data-[state=checked]:text-primary-foreground dark:data-[state=checked]:bg-primary data-[state=checked]:border-primary focus-visible:border-ring focus-visible:ring-ring/50 aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive size-4 shrink-0 rounded-[4px] border shadow-xs transition-shadow outline-none focus-visible:ring-[3px] disabled:cursor-not-allowed disabled:opacity-50" id="remember">
</button>
<input type="checkbox" aria-hidden="true" tabindex="-1" style="position:absolute;pointer-events:none;opacity:0;margin:0;transform:translateX(-100%)" value="on"/>
<label for="remember" class="text-sm text-gray-600 cursor-pointer">Remember me</label>
</div>
<button type="button" class="text-sm text-blue-600 hover:text-blue-700">Forgot password?</button>
</div>
<button data-slot="button" class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium transition-all disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg:not([class*=&#x27;size-&#x27;])]:size-4 shrink-0 [&amp;_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive text-primary-foreground hover:bg-primary/90 h-9 px-4 has-[&gt;svg]:px-3 w-full rounded-full py-6 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 shadow-lg shadow-blue-500/30" type="submit">Sign In<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right ml-2 h-5 w-5">
<path d="M5 12h14">
</path>
<path d="m12 5 7 7-7 7">
</path>
</svg>
</button>
<div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-xl">
<p class="text-sm text-gray-700">
<strong>Demo Credentials:</strong>
</p>
<p class="text-xs text-gray-600 mt-2">Client: any email / any password</p>
<p class="text-xs text-gray-600">Admin: admin@aakaari.com / any password</p>
</div>
</form>
</div>
<div data-state="inactive" data-orientation="horizontal" role="tabpanel" aria-labelledby="radix-:R2:-trigger-signup" hidden="" id="radix-:R2:-content-signup" tabindex="0" data-slot="tabs-content" class="flex-1 outline-none">
</div>
</div>
</div>
<div class="text-center mt-6">
<a href="<?php echo esc_url(home_url('/')); ?>" class="text-sm text-gray-600 hover:text-blue-600">← Back to Home</a>
</div>
</div>
</div>
<?php
get_footer('minimal');
?>