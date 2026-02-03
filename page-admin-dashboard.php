<?php
get_header();
?>
<div class="min-h-screen bg-gray-50">
<div class="flex">
<aside class="hidden lg:flex w-64 flex-col fixed left-0 top-16 h-[calc(100vh-4rem)] bg-white border-r border-gray-200">
<div class="p-6 border-b border-gray-200">
<div class="flex items-center">
<span data-slot="avatar" class="relative flex size-10 shrink-0 overflow-hidden rounded-full h-12 w-12 mr-3">
<span data-slot="avatar-fallback" class="flex size-full items-center justify-center rounded-full bg-gradient-to-br from-purple-600 to-purple-500 text-white">AD</span>
</span>
<div class="flex-1">
<p class="font-medium text-gray-900">Admin</p>
<p class="text-sm text-gray-600">admin@aakaari.com</p>
</div>
</div>
</div>
<nav class="flex-1 p-4 overflow-y-auto">
<div class="space-y-1">
<button class="w-full flex items-center px-4 py-3 rounded-xl text-sm transition-colors bg-gradient-to-r from-purple-600 to-purple-500 text-white shadow-lg shadow-purple-500/30">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard h-5 w-5 mr-3">
<rect width="7" height="9" x="3" y="3" rx="1">
</rect>
<rect width="7" height="5" x="14" y="3" rx="1">
</rect>
<rect width="7" height="9" x="14" y="12" rx="1">
</rect>
<rect width="7" height="5" x="3" y="16" rx="1">
</rect>
</svg>Overview</button>
<button class="w-full flex items-center px-4 py-3 rounded-xl text-sm transition-colors text-gray-700 hover:bg-gray-100">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ticket h-5 w-5 mr-3">
<path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z">
</path>
<path d="M13 5v2">
</path>
<path d="M13 17v2">
</path>
<path d="M13 11v2">
</path>
</svg>All Tickets<span data-slot="badge" class="inline-flex items-center justify-center rounded-md border px-2 py-0.5 text-xs font-medium w-fit whitespace-nowrap shrink-0 [&amp;&gt;svg]:size-3 gap-1 [&amp;&gt;svg]:pointer-events-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive transition-[color,box-shadow] overflow-hidden border-transparent [a&amp;]:hover:bg-primary/90 ml-auto bg-red-500 text-white">24</span>
</button>
<button class="w-full flex items-center px-4 py-3 rounded-xl text-sm transition-colors text-gray-700 hover:bg-gray-100">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users h-5 w-5 mr-3">
<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2">
</path>
<circle cx="9" cy="7" r="4">
</circle>
<path d="M22 21v-2a4 4 0 0 0-3-3.87">
</path>
<path d="M16 3.13a4 4 0 0 1 0 7.75">
</path>
</svg>Clients</button>
<button class="w-full flex items-center px-4 py-3 rounded-xl text-sm transition-colors text-gray-700 hover:bg-gray-100">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-plus h-5 w-5 mr-3">
<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2">
</path>
<circle cx="9" cy="7" r="4">
</circle>
<line x1="19" x2="19" y1="8" y2="14">
</line>
<line x1="22" x2="16" y1="11" y2="11">
</line>
</svg>Team</button>
<button class="w-full flex items-center px-4 py-3 rounded-xl text-sm transition-colors text-gray-700 hover:bg-gray-100">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-dollar-sign h-5 w-5 mr-3">
<line x1="12" x2="12" y1="2" y2="22">
</line>
<path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6">
</path>
</svg>Revenue</button>
<button class="w-full flex items-center px-4 py-3 rounded-xl text-sm transition-colors text-gray-700 hover:bg-gray-100">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chart-column h-5 w-5 mr-3">
<path d="M3 3v16a2 2 0 0 0 2 2h16">
</path>
<path d="M18 17V9">
</path>
<path d="M13 17V5">
</path>
<path d="M8 17v-3">
</path>
</svg>Analytics</button>
<button class="w-full flex items-center px-4 py-3 rounded-xl text-sm transition-colors text-gray-700 hover:bg-gray-100">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bell h-5 w-5 mr-3">
<path d="M10.268 21a2 2 0 0 0 3.464 0">
</path>
<path d="M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326">
</path>
</svg>Notifications<span data-slot="badge" class="inline-flex items-center justify-center rounded-md border px-2 py-0.5 text-xs font-medium w-fit whitespace-nowrap shrink-0 [&amp;&gt;svg]:size-3 gap-1 [&amp;&gt;svg]:pointer-events-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive transition-[color,box-shadow] overflow-hidden border-transparent [a&amp;]:hover:bg-primary/90 ml-auto bg-red-500 text-white">5</span>
</button>
<button class="w-full flex items-center px-4 py-3 rounded-xl text-sm transition-colors text-gray-700 hover:bg-gray-100">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-settings h-5 w-5 mr-3">
<path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z">
</path>
<circle cx="12" cy="12" r="3">
</circle>
</svg>Settings</button>
</div>
</nav>
<div class="p-4 border-t border-gray-200">
<button data-slot="button" class="inline-flex items-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-all disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg:not([class*=&#x27;size-&#x27;])]:size-4 shrink-0 [&amp;_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive dark:hover:bg-accent/50 h-9 px-4 py-2 has-[&gt;svg]:px-3 w-full justify-start text-red-600 hover:text-red-700 hover:bg-red-50">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out h-5 w-5 mr-3">
<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4">
</path>
<polyline points="16 17 21 12 16 7">
</polyline>
<line x1="21" x2="9" y1="12" y2="12">
</line>
</svg>Logout</button>
</div>
</aside>
<main class="flex-1 lg:ml-64 p-6 mt-16">
<div class="lg:hidden mb-6 flex items-center justify-between">
<h1 class="text-2xl font-bold text-gray-900">Admin Dashboard</h1>
<button data-slot="button" class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium transition-all disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg:not([class*=&#x27;size-&#x27;])]:size-4 shrink-0 [&amp;_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive hover:bg-accent hover:text-accent-foreground dark:hover:bg-accent/50 size-9 rounded-md">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu h-6 w-6">
<line x1="4" x2="20" y1="12" y2="12">
</line>
<line x1="4" x2="20" y1="6" y2="6">
</line>
<line x1="4" x2="20" y1="18" y2="18">
</line>
</svg>
</button>
</div>
<div class="max-w-7xl mx-auto">
<div class="space-y-6">
<?php if (function_exists('aakaari_build_render_admin_projects')) { echo aakaari_build_render_admin_projects(); } ?>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
<div data-slot="card" class="bg-card text-card-foreground flex flex-col gap-6 rounded-xl p-6 border-2 border-gray-200 hover:shadow-xl transition-all">
<div class="flex items-center justify-between mb-4">
<div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ticket h-6 w-6 text-blue-600">
<path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z">
</path>
<path d="M13 5v2">
</path>
<path d="M13 17v2">
</path>
<path d="M13 11v2">
</path>
</svg>
</div>
<span data-slot="badge" class="inline-flex items-center justify-center rounded-md px-2 py-0.5 text-xs font-medium w-fit whitespace-nowrap shrink-0 [&amp;&gt;svg]:size-3 gap-1 [&amp;&gt;svg]:pointer-events-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive transition-[color,box-shadow] overflow-hidden border-transparent [a&amp;]:hover:bg-primary/90 bg-green-50 text-green-600 border-0">+12%</span>
</div>
<p class="text-sm text-gray-600 mb-1">Active Tickets</p>
<p class="text-3xl font-bold text-gray-900 mb-1">24</p>
<p class="text-xs text-gray-500">8 Critical</p>
</div>
<div data-slot="card" class="bg-card text-card-foreground flex flex-col gap-6 rounded-xl p-6 border-2 border-gray-200 hover:shadow-xl transition-all">
<div class="flex items-center justify-between mb-4">
<div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-50">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users h-6 w-6 text-green-600">
<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2">
</path>
<circle cx="9" cy="7" r="4">
</circle>
<path d="M22 21v-2a4 4 0 0 0-3-3.87">
</path>
<path d="M16 3.13a4 4 0 0 1 0 7.75">
</path>
</svg>
</div>
<span data-slot="badge" class="inline-flex items-center justify-center rounded-md px-2 py-0.5 text-xs font-medium w-fit whitespace-nowrap shrink-0 [&amp;&gt;svg]:size-3 gap-1 [&amp;&gt;svg]:pointer-events-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive transition-[color,box-shadow] overflow-hidden border-transparent [a&amp;]:hover:bg-primary/90 bg-green-50 text-green-600 border-0">+8%</span>
</div>
<p class="text-sm text-gray-600 mb-1">Total Clients</p>
<p class="text-3xl font-bold text-gray-900 mb-1">487</p>
<p class="text-xs text-gray-500">23 New this week</p>
</div>
<div data-slot="card" class="bg-card text-card-foreground flex flex-col gap-6 rounded-xl p-6 border-2 border-gray-200 hover:shadow-xl transition-all">
<div class="flex items-center justify-between mb-4">
<div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-50">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-dollar-sign h-6 w-6 text-purple-600">
<line x1="12" x2="12" y1="2" y2="22">
</line>
<path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6">
</path>
</svg>
</div>
<span data-slot="badge" class="inline-flex items-center justify-center rounded-md px-2 py-0.5 text-xs font-medium w-fit whitespace-nowrap shrink-0 [&amp;&gt;svg]:size-3 gap-1 [&amp;&gt;svg]:pointer-events-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive transition-[color,box-shadow] overflow-hidden border-transparent [a&amp;]:hover:bg-primary/90 bg-green-50 text-green-600 border-0">+23%</span>
</div>
<p class="text-sm text-gray-600 mb-1">Revenue (MTD)</p>
<p class="text-3xl font-bold text-gray-900 mb-1">$12,450</p>
<p class="text-xs text-gray-500">$45k target</p>
</div>
<div data-slot="card" class="bg-card text-card-foreground flex flex-col gap-6 rounded-xl p-6 border-2 border-gray-200 hover:shadow-xl transition-all">
<div class="flex items-center justify-between mb-4">
<div class="flex h-12 w-12 items-center justify-center rounded-xl bg-yellow-50">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock h-6 w-6 text-yellow-600">
<circle cx="12" cy="12" r="10">
</circle>
<polyline points="12 6 12 12 16 14">
</polyline>
</svg>
</div>
<span data-slot="badge" class="inline-flex items-center justify-center rounded-md px-2 py-0.5 text-xs font-medium w-fit whitespace-nowrap shrink-0 [&amp;&gt;svg]:size-3 gap-1 [&amp;&gt;svg]:pointer-events-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive transition-[color,box-shadow] overflow-hidden border-transparent [a&amp;]:hover:bg-primary/90 bg-red-50 text-red-600 border-0">-15%</span>
</div>
<p class="text-sm text-gray-600 mb-1">Avg Response</p>
<p class="text-3xl font-bold text-gray-900 mb-1">1.2hrs</p>
<p class="text-xs text-gray-500">Target: &lt;2hrs</p>
</div>
</div>
<div data-slot="card" class="bg-card text-card-foreground flex flex-col gap-6 rounded-xl p-6 border-2 border-gray-200">
<h3 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h3>
<div class="grid grid-cols-2 md:grid-cols-4 gap-3">
<button data-slot="button" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-all disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg:not([class*=&#x27;size-&#x27;])]:size-4 shrink-0 [&amp;_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive bg-background text-foreground hover:bg-accent hover:text-accent-foreground dark:bg-input/30 dark:border-input dark:hover:bg-input/50 px-4 has-[&gt;svg]:px-3 flex-col h-auto py-4 border-2">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus h-5 w-5 mb-2">
<path d="M5 12h14">
</path>
<path d="M12 5v14">
</path>
</svg>
<span class="text-sm">New Ticket</span>
</button>
<button data-slot="button" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-all disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg:not([class*=&#x27;size-&#x27;])]:size-4 shrink-0 [&amp;_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive bg-background text-foreground hover:bg-accent hover:text-accent-foreground dark:bg-input/30 dark:border-input dark:hover:bg-input/50 px-4 has-[&gt;svg]:px-3 flex-col h-auto py-4 border-2">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-plus h-5 w-5 mb-2">
<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2">
</path>
<circle cx="9" cy="7" r="4">
</circle>
<line x1="19" x2="19" y1="8" y2="14">
</line>
<line x1="22" x2="16" y1="11" y2="11">
</line>
</svg>
<span class="text-sm">Add Client</span>
</button>
<button data-slot="button" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-all disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg:not([class*=&#x27;size-&#x27;])]:size-4 shrink-0 [&amp;_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive bg-background text-foreground hover:bg-accent hover:text-accent-foreground dark:bg-input/30 dark:border-input dark:hover:bg-input/50 px-4 has-[&gt;svg]:px-3 flex-col h-auto py-4 border-2">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download h-5 w-5 mb-2">
<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4">
</path>
<polyline points="7 10 12 15 17 10">
</polyline>
<line x1="12" x2="12" y1="15" y2="3">
</line>
</svg>
<span class="text-sm">Export Data</span>
</button>
<button data-slot="button" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-all disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg:not([class*=&#x27;size-&#x27;])]:size-4 shrink-0 [&amp;_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive bg-background text-foreground hover:bg-accent hover:text-accent-foreground dark:bg-input/30 dark:border-input dark:hover:bg-input/50 px-4 has-[&gt;svg]:px-3 flex-col h-auto py-4 border-2">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chart-column h-5 w-5 mb-2">
<path d="M3 3v16a2 2 0 0 0 2 2h16">
</path>
<path d="M18 17V9">
</path>
<path d="M13 17V5">
</path>
<path d="M8 17v-3">
</path>
</svg>
<span class="text-sm">Reports</span>
</button>
</div>
</div>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
<div data-slot="card" class="bg-card text-card-foreground flex flex-col gap-6 rounded-xl p-6 border-2 border-gray-200">
<h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-activity h-5 w-5 mr-2 text-purple-600">
<path d="M22 12h-2.48a2 2 0 0 0-1.93 1.46l-2.35 8.36a.25.25 0 0 1-.48 0L9.24 2.18a.25.25 0 0 0-.48 0l-2.35 8.36A2 2 0 0 1 4.49 12H2">
</path>
</svg>Recent Activity</h3>
<div class="space-y-4">
<div class="flex items-start pb-3 border-b border-gray-100 last:border-0">
<div class="flex h-8 w-8 items-center justify-center rounded-lg bg-purple-50 mr-3 flex-shrink-0">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-activity h-4 w-4 text-purple-600">
<path d="M22 12h-2.48a2 2 0 0 0-1.93 1.46l-2.35 8.36a.25.25 0 0 1-.48 0L9.24 2.18a.25.25 0 0 0-.48 0l-2.35 8.36A2 2 0 0 1 4.49 12H2">
</path>
</svg>
</div>
<div class="flex-1">
<p class="text-sm text-gray-900">Ticket TKT-1234 assigned to Mike R.</p>
<p class="text-xs text-gray-500">5 mins ago</p>
</div>
</div>
<div class="flex items-start pb-3 border-b border-gray-100 last:border-0">
<div class="flex h-8 w-8 items-center justify-center rounded-lg bg-purple-50 mr-3 flex-shrink-0">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-activity h-4 w-4 text-purple-600">
<path d="M22 12h-2.48a2 2 0 0 0-1.93 1.46l-2.35 8.36a.25.25 0 0 1-.48 0L9.24 2.18a.25.25 0 0 0-.48 0l-2.35 8.36A2 2 0 0 1 4.49 12H2">
</path>
</svg>
</div>
<div class="flex-1">
<p class="text-sm text-gray-900">Payment received from Sarah Chen ($79)</p>
<p class="text-xs text-gray-500">12 mins ago</p>
</div>
</div>
<div class="flex items-start pb-3 border-b border-gray-100 last:border-0">
<div class="flex h-8 w-8 items-center justify-center rounded-lg bg-purple-50 mr-3 flex-shrink-0">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-activity h-4 w-4 text-purple-600">
<path d="M22 12h-2.48a2 2 0 0 0-1.93 1.46l-2.35 8.36a.25.25 0 0 1-.48 0L9.24 2.18a.25.25 0 0 0-.48 0l-2.35 8.36A2 2 0 0 1 4.49 12H2">
</path>
</svg>
</div>
<div class="flex-1">
<p class="text-sm text-gray-900">New client registered: Emma Wilson</p>
<p class="text-xs text-gray-500">25 mins ago</p>
</div>
</div>
<div class="flex items-start pb-3 border-b border-gray-100 last:border-0">
<div class="flex h-8 w-8 items-center justify-center rounded-lg bg-purple-50 mr-3 flex-shrink-0">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-activity h-4 w-4 text-purple-600">
<path d="M22 12h-2.48a2 2 0 0 0-1.93 1.46l-2.35 8.36a.25.25 0 0 1-.48 0L9.24 2.18a.25.25 0 0 0-.48 0l-2.35 8.36A2 2 0 0 1 4.49 12H2">
</path>
</svg>
</div>
<div class="flex-1">
<p class="text-sm text-gray-900">Ticket TKT-1232 marked as completed</p>
<p class="text-xs text-gray-500">1 hour ago</p>
</div>
</div>
<div class="flex items-start pb-3 border-b border-gray-100 last:border-0">
<div class="flex h-8 w-8 items-center justify-center rounded-lg bg-purple-50 mr-3 flex-shrink-0">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-activity h-4 w-4 text-purple-600">
<path d="M22 12h-2.48a2 2 0 0 0-1.93 1.46l-2.35 8.36a.25.25 0 0 1-.48 0L9.24 2.18a.25.25 0 0 0-.48 0l-2.35 8.36A2 2 0 0 1 4.49 12H2">
</path>
</svg>
</div>
<div class="flex-1">
<p class="text-sm text-gray-900">Anna K. updated ticket TKT-1230</p>
<p class="text-xs text-gray-500">2 hours ago</p>
</div>
</div>
</div>
</div>
<div data-slot="card" class="bg-card text-card-foreground flex flex-col gap-6 rounded-xl p-6 border-2 border-gray-200">
<h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap h-5 w-5 mr-2 text-yellow-600">
<path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z">
</path>
</svg>Team Performance</h3>
<div class="space-y-4">
<div class="flex items-center justify-between">
<div class="flex items-center">
<span data-slot="avatar" class="relative flex size-10 shrink-0 overflow-hidden rounded-full h-10 w-10 mr-3">
<span data-slot="avatar-fallback" class="flex size-full items-center justify-center rounded-full bg-gradient-to-br from-purple-600 to-purple-500 text-white text-sm">MR</span>
</span>
<div>
<p class="text-sm font-medium text-gray-900">Mike Roberts</p>
<p class="text-xs text-gray-500">Senior Engineer</p>
</div>
</div>
<div class="text-right">
<p class="text-sm font-semibold text-gray-900">5 active</p>
<p class="text-xs text-green-600">+3 today</p>
</div>
</div>
<div class="flex items-center justify-between">
<div class="flex items-center">
<span data-slot="avatar" class="relative flex size-10 shrink-0 overflow-hidden rounded-full h-10 w-10 mr-3">
<span data-slot="avatar-fallback" class="flex size-full items-center justify-center rounded-full bg-gradient-to-br from-purple-600 to-purple-500 text-white text-sm">AK</span>
</span>
<div>
<p class="text-sm font-medium text-gray-900">Anna Kumar</p>
<p class="text-xs text-gray-500">WordPress Specialist</p>
</div>
</div>
<div class="text-right">
<p class="text-sm font-semibold text-gray-900">4 active</p>
<p class="text-xs text-green-600">+2 today</p>
</div>
</div>
<div class="flex items-center justify-between">
<div class="flex items-center">
<span data-slot="avatar" class="relative flex size-10 shrink-0 overflow-hidden rounded-full h-10 w-10 mr-3">
<span data-slot="avatar-fallback" class="flex size-full items-center justify-center rounded-full bg-gradient-to-br from-purple-600 to-purple-500 text-white text-sm">JD</span>
</span>
<div>
<p class="text-sm font-medium text-gray-900">John Davis</p>
<p class="text-xs text-gray-500">Full Stack Developer</p>
</div>
</div>
<div class="text-right">
<p class="text-sm font-semibold text-gray-900">6 active</p>
<p class="text-xs text-green-600">+1 today</p>
</div>
</div>
<div class="flex items-center justify-between">
<div class="flex items-center">
<span data-slot="avatar" class="relative flex size-10 shrink-0 overflow-hidden rounded-full h-10 w-10 mr-3">
<span data-slot="avatar-fallback" class="flex size-full items-center justify-center rounded-full bg-gradient-to-br from-purple-600 to-purple-500 text-white text-sm">SM</span>
</span>
<div>
<p class="text-sm font-medium text-gray-900">Sarah Mitchell</p>
<p class="text-xs text-gray-500">Security Expert</p>
</div>
</div>
<div class="text-right">
<p class="text-sm font-semibold text-gray-900">3 active</p>
<p class="text-xs text-green-600">+4 today</p>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</main>
</div>
</div>
<?php
get_footer('minimal');
?>