import { Card, CardContent, CardDescription, CardHeader, CardTitle } from './ui/card';
import { Button } from './ui/button';
import { Badge } from './ui/badge';
import { Check, X, ArrowRight, Shield, Zap, Crown } from 'lucide-react';
import { Tabs, TabsContent, TabsList, TabsTrigger } from './ui/tabs';

interface MaintenancePlansPageProps {
  onNavigate: (page: string) => void;
}

export function MaintenancePlansPage({ onNavigate }: MaintenancePlansPageProps) {
  const plans = [
    {
      id: 'starter',
      name: 'Starter',
      icon: Shield,
      description: 'Essential maintenance for small websites',
      monthlyPrice: '$199',
      yearlyPrice: '$1,990',
      yearlyDiscount: '17% off',
      color: 'from-blue-500 to-blue-600',
      features: {
        included: [
          'Monthly WordPress core updates',
          'Monthly plugin updates',
          'Monthly theme updates',
          'Daily backups (30-day retention)',
          'Basic security monitoring',
          'Monthly uptime report',
          '2 hours of fix-an-issue support',
          'Email support (24h response)',
        ],
        excluded: [
          'Priority support',
          'Performance optimization',
          'Content updates',
          'Security hardening',
          'Custom development',
        ],
      },
      popular: false,
    },
    {
      id: 'pro',
      name: 'Pro',
      icon: Zap,
      description: 'Complete maintenance for growing businesses',
      monthlyPrice: '$399',
      yearlyPrice: '$3,990',
      yearlyDiscount: '17% off',
      color: 'from-primary to-blue-600',
      features: {
        included: [
          'Everything in Starter, plus:',
          'Weekly WordPress updates',
          'Weekly plugin & theme updates',
          'Daily backups (90-day retention)',
          'Advanced security monitoring',
          'Malware scanning & removal',
          'Performance optimization',
          'Monthly performance report',
          '5 hours of fix-an-issue support',
          'Priority email & chat support (4h response)',
          '1 hour of content updates',
          'Uptime monitoring with alerts',
        ],
        excluded: [
          'Custom development',
          'SEO optimization',
          'Migration services',
        ],
      },
      popular: true,
    },
    {
      id: 'business',
      name: 'Business',
      icon: Crown,
      description: 'Premium support for business-critical sites',
      monthlyPrice: '$799',
      yearlyPrice: '$7,990',
      yearlyDiscount: '17% off',
      color: 'from-purple-500 to-purple-600',
      features: {
        included: [
          'Everything in Pro, plus:',
          'Real-time updates monitoring',
          'Daily plugin & theme updates',
          'Real-time backups (unlimited retention)',
          'Enterprise security suite',
          'Advanced malware protection',
          'Performance optimization (monthly)',
          'CDN setup & optimization',
          'Database optimization',
          '10 hours of fix-an-issue support',
          'Priority phone, chat & email support (1h response)',
          '3 hours of content updates',
          'Dedicated account manager',
          '99.9% uptime guarantee',
          'Custom development (2 hours/month)',
        ],
        excluded: [],
      },
      popular: false,
    },
  ];

  const addOns = [
    {
      name: 'Extra Content Updates',
      description: '1 additional hour per month',
      price: '$50/mo',
    },
    {
      name: 'Extra Support Hours',
      description: '2 additional fix-an-issue hours',
      price: '$99/mo',
    },
    {
      name: 'SEO Monitoring',
      description: 'Monthly SEO health check & report',
      price: '$149/mo',
    },
    {
      name: 'Custom Development',
      description: '2 hours of custom work per month',
      price: '$199/mo',
    },
  ];

  const faqs = [
    {
      q: 'What happens if I exceed my support hours?',
      a: 'Additional support hours are billed at $99/hour. You can also upgrade to a higher plan anytime.',
    },
    {
      q: 'Can I cancel anytime?',
      a: 'Yes! Monthly plans can be cancelled anytime. Yearly plans have a 30-day money-back guarantee.',
    },
    {
      q: 'What if my site gets hacked?',
      a: 'Pro and Business plans include malware removal. Starter plan clients can request emergency cleanup for an additional fee.',
    },
    {
      q: 'Do you work on all types of WordPress sites?',
      a: 'Yes! We work with all WordPress installations, including WooCommerce, Multisite, and custom setups.',
    },
    {
      q: 'What are content updates?',
      a: 'Content updates include text changes, image uploads, menu updates, and other non-development tasks.',
    },
    {
      q: 'Is there a setup fee?',
      a: 'No setup fees! We include initial site audit and optimization in all plans at no extra cost.',
    },
  ];

  return (
    <div className="w-full py-12">
      <div className="container mx-auto px-4">
        {/* Header */}
        <div className="max-w-3xl mx-auto text-center mb-12">
          <Badge className="mb-4" variant="secondary">
            Save 17% with Yearly Plans
          </Badge>
          <h1 className="text-4xl md:text-5xl mb-4">Maintenance Plans</h1>
          <p className="text-lg text-muted-foreground">
            Keep your WordPress website secure, fast, and up-to-date with
            professional maintenance by real experts.
          </p>
        </div>

        {/* Billing Toggle */}
        <Tabs defaultValue="monthly" className="w-full max-w-7xl mx-auto">
          <TabsList className="grid w-full max-w-md mx-auto grid-cols-2 mb-12">
            <TabsTrigger value="monthly">Monthly</TabsTrigger>
            <TabsTrigger value="yearly">Yearly (Save 17%)</TabsTrigger>
          </TabsList>

          <TabsContent value="monthly">
            <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
              {plans.map((plan) => (
                <Card
                  key={plan.id}
                  className={`relative ${
                    plan.popular ? 'ring-2 ring-primary shadow-xl' : ''
                  }`}
                >
                  {plan.popular && (
                    <div className="absolute -top-4 left-0 right-0 flex justify-center">
                      <Badge className="bg-primary">Most Popular</Badge>
                    </div>
                  )}
                  <CardHeader>
                    <div
                      className={`flex h-12 w-12 items-center justify-center rounded-lg bg-gradient-to-br ${plan.color} mb-4`}
                    >
                      <plan.icon className="h-6 w-6 text-white" />
                    </div>
                    <CardTitle>{plan.name}</CardTitle>
                    <CardDescription>{plan.description}</CardDescription>
                    <div className="pt-4">
                      <div className="flex items-baseline">
                        <span className="text-4xl font-bold">
                          {plan.monthlyPrice}
                        </span>
                        <span className="text-muted-foreground ml-2">/month</span>
                      </div>
                    </div>
                  </CardHeader>
                  <CardContent>
                    <Button
                      className="w-full mb-6"
                      variant={plan.popular ? 'default' : 'outline'}
                      onClick={() => onNavigate('checkout')}
                    >
                      Get Started
                      <ArrowRight className="ml-2 h-4 w-4" />
                    </Button>

                    <div className="space-y-3">
                      {plan.features.included.map((feature, index) => (
                        <div key={index} className="flex items-start">
                          <Check className="h-5 w-5 text-primary mr-2 flex-shrink-0 mt-0.5" />
                          <span className="text-sm">{feature}</span>
                        </div>
                      ))}
                      {plan.features.excluded.length > 0 && (
                        <>
                          <div className="pt-2 border-t" />
                          {plan.features.excluded.map((feature, index) => (
                            <div key={index} className="flex items-start">
                              <X className="h-5 w-5 text-muted-foreground mr-2 flex-shrink-0 mt-0.5" />
                              <span className="text-sm text-muted-foreground">
                                {feature}
                              </span>
                            </div>
                          ))}
                        </>
                      )}
                    </div>
                  </CardContent>
                </Card>
              ))}
            </div>
          </TabsContent>

          <TabsContent value="yearly">
            <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
              {plans.map((plan) => (
                <Card
                  key={plan.id}
                  className={`relative ${
                    plan.popular ? 'ring-2 ring-primary shadow-xl' : ''
                  }`}
                >
                  {plan.popular && (
                    <div className="absolute -top-4 left-0 right-0 flex justify-center">
                      <Badge className="bg-primary">Most Popular</Badge>
                    </div>
                  )}
                  <CardHeader>
                    <div
                      className={`flex h-12 w-12 items-center justify-center rounded-lg bg-gradient-to-br ${plan.color} mb-4`}
                    >
                      <plan.icon className="h-6 w-6 text-white" />
                    </div>
                    <CardTitle>{plan.name}</CardTitle>
                    <CardDescription>{plan.description}</CardDescription>
                    <div className="pt-4">
                      <Badge variant="secondary" className="mb-2">
                        {plan.yearlyDiscount}
                      </Badge>
                      <div className="flex items-baseline">
                        <span className="text-4xl font-bold">
                          {plan.yearlyPrice}
                        </span>
                        <span className="text-muted-foreground ml-2">/year</span>
                      </div>
                      <p className="text-sm text-muted-foreground mt-1">
                        ${Math.round(parseInt(plan.yearlyPrice.replace(/[$,]/g, '')) / 12)}/month
                      </p>
                    </div>
                  </CardHeader>
                  <CardContent>
                    <Button
                      className="w-full mb-6"
                      variant={plan.popular ? 'default' : 'outline'}
                      onClick={() => onNavigate('checkout')}
                    >
                      Get Started
                      <ArrowRight className="ml-2 h-4 w-4" />
                    </Button>

                    <div className="space-y-3">
                      {plan.features.included.map((feature, index) => (
                        <div key={index} className="flex items-start">
                          <Check className="h-5 w-5 text-primary mr-2 flex-shrink-0 mt-0.5" />
                          <span className="text-sm">{feature}</span>
                        </div>
                      ))}
                      {plan.features.excluded.length > 0 && (
                        <>
                          <div className="pt-2 border-t" />
                          {plan.features.excluded.map((feature, index) => (
                            <div key={index} className="flex items-start">
                              <X className="h-5 w-5 text-muted-foreground mr-2 flex-shrink-0 mt-0.5" />
                              <span className="text-sm text-muted-foreground">
                                {feature}
                              </span>
                            </div>
                          ))}
                        </>
                      )}
                    </div>
                  </CardContent>
                </Card>
              ))}
            </div>
          </TabsContent>
        </Tabs>

        {/* Add-ons */}
        <section className="mt-20 max-w-5xl mx-auto">
          <div className="text-center mb-8">
            <h2 className="text-3xl mb-2">Available Add-ons</h2>
            <p className="text-muted-foreground">
              Enhance your plan with additional services
            </p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            {addOns.map((addon, index) => (
              <Card key={index}>
                <CardContent className="p-6 flex items-center justify-between">
                  <div>
                    <h4 className="mb-1">{addon.name}</h4>
                    <p className="text-sm text-muted-foreground">
                      {addon.description}
                    </p>
                  </div>
                  <div className="text-right">
                    <p className="font-bold text-primary">{addon.price}</p>
                  </div>
                </CardContent>
              </Card>
            ))}
          </div>
        </section>

        {/* FAQs */}
        <section className="mt-20 max-w-3xl mx-auto">
          <div className="text-center mb-8">
            <h2 className="text-3xl mb-2">Frequently Asked Questions</h2>
          </div>

          <div className="space-y-4">
            {faqs.map((faq, index) => (
              <Card key={index}>
                <CardContent className="p-6">
                  <h4 className="mb-2">{faq.q}</h4>
                  <p className="text-sm text-muted-foreground">{faq.a}</p>
                </CardContent>
              </Card>
            ))}
          </div>
        </section>

        {/* CTA */}
        <section className="mt-20">
          <Card className="bg-gradient-to-r from-primary to-blue-600 text-white border-0">
            <CardContent className="p-12 text-center">
              <h2 className="text-3xl mb-4">Not Sure Which Plan to Choose?</h2>
              <p className="text-lg opacity-90 mb-8 max-w-2xl mx-auto">
                Talk to our team. We'll help you find the perfect plan for your
                website needs.
              </p>
              <div className="flex flex-col sm:flex-row gap-4 justify-center">
                <Button
                  size="lg"
                  variant="secondary"
                  onClick={() => onNavigate('contact')}
                >
                  Contact Sales
                </Button>
                <Button
                  size="lg"
                  variant="outline"
                  className="bg-transparent border-white text-white hover:bg-white/10"
                  onClick={() => onNavigate('fix-an-issue')}
                >
                  Start with Fix-an-Issue
                </Button>
              </div>
            </CardContent>
          </Card>
        </section>
      </div>
    </div>
  );
}
