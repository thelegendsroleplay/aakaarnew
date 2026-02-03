import { Button } from './ui/button';
import { Card } from './ui/card';
import { Badge } from './ui/badge';
import { motion } from 'motion/react';
import {
  Shield,
  Star,
  ArrowRight,
  CheckCircle,
  Sparkles,
  TrendingUp,
  Users,
  Clock,
  Code2,
  Server,
  Lock,
  ShoppingCart,
  Zap,
  Smartphone,
  Database,
  AlertTriangle,
  Settings,
} from 'lucide-react';

interface HomePageProps {
  onNavigate: (page: string) => void;
}

export function HomePage({ onNavigate }: HomePageProps) {
  const stats = [
    { value: '2,500+', label: 'Issues Fixed', icon: CheckCircle },
    { value: '98%', label: 'Success Rate', icon: TrendingUp },
    { value: '< 2hrs', label: 'Avg Response', icon: Clock },
    { value: '500+', label: 'Happy Clients', icon: Users },
  ];

  const issueCategories = [
    {
      name: 'WordPress Core',
      icon: Code2,
      color: 'blue',
      issues: ['White Screen of Death', 'Plugin Conflicts', 'Forms Not Working', 'Site Down'],
      priceRange: '$15 - $99',
    },
    {
      name: 'Infrastructure',
      icon: Server,
      color: 'purple',
      issues: ['500 Server Error', 'Database Issues', 'Email Problems', 'DNS/Domain'],
      priceRange: '$15 - $149',
    },
    {
      name: 'Security',
      icon: Lock,
      color: 'red',
      issues: ['Hacked Website', 'Malware Removal', 'SSL Errors', 'Redirect Hacks'],
      priceRange: '$15 - $149',
    },
    {
      name: 'WooCommerce',
      icon: ShoppingCart,
      color: 'green',
      issues: ['Payment Gateway', 'Checkout Issues', 'Orders Not Processing'],
      priceRange: '$25 - $149',
    },
    {
      name: 'Performance',
      icon: Zap,
      color: 'yellow',
      issues: ['Slow Loading', 'Core Web Vitals', 'Mobile Responsive'],
      priceRange: '$19 - $119',
    },
    {
      name: 'Database',
      icon: Database,
      color: 'indigo',
      issues: ['Connection Errors', 'Data Migration', 'Backup & Restore'],
      priceRange: '$19 - $99',
    },
  ];

  const features = [
    {
      icon: CheckCircle,
      title: '24/7 Ticket Support',
      description: 'Submit tickets anytime, get expert responses around the clock',
    },
    {
      icon: Shield,
      title: 'Secure Access',
      description: 'Encrypted credential storage with temporary admin accounts',
    },
    {
      icon: Clock,
      title: 'Fast Response',
      description: 'Priority support available with response times under 2 hours',
    },
    {
      icon: TrendingUp,
      title: 'No Hidden Charges',
      description: 'Fixed pricing per issue, transparent and upfront',
    },
  ];

  const testimonials = [
    {
      name: 'Sarah Chen',
      role: 'E-commerce Owner',
      content: 'My site was down during Black Friday. Aakaari fixed it in 45 minutes. Absolute lifesavers!',
      rating: 5,
      avatar: 'SC',
    },
    {
      name: 'Marcus Rodriguez',
      role: 'Agency Director',
      content: 'We trust Aakaari with all our client emergencies. Real experts who know their stuff.',
      rating: 5,
      avatar: 'MR',
    },
    {
      name: 'Lisa Thompson',
      role: 'Blogger',
      content: 'Finally found professionals who actually understand WordPress. Worth every penny.',
      rating: 5,
      avatar: 'LT',
    },
  ];

  const getCategoryColor = (color: string) => {
    const colors: Record<string, { bg: string; text: string; border: string }> = {
      blue: { bg: 'bg-blue-50', text: 'text-blue-600', border: 'border-blue-200' },
      purple: { bg: 'bg-purple-50', text: 'text-purple-600', border: 'border-purple-200' },
      red: { bg: 'bg-red-50', text: 'text-red-600', border: 'border-red-200' },
      green: { bg: 'bg-emerald-50', text: 'text-emerald-600', border: 'border-emerald-200' },
      yellow: { bg: 'bg-yellow-50', text: 'text-yellow-600', border: 'border-yellow-200' },
      indigo: { bg: 'bg-indigo-50', text: 'text-indigo-600', border: 'border-indigo-200' },
    };
    return colors[color] || colors.blue;
  };

  return (
    <div className="w-full pt-24 overflow-hidden bg-gradient-to-b from-gray-50 to-white">
      {/* Hero Section */}
      <section className="relative py-20 md:py-32 px-4">
        <div className="container mx-auto relative z-10">
          <div className="max-w-5xl mx-auto text-center">
            <motion.div
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6 }}
            >
              <Badge className="mb-6 px-4 py-2 rounded-full bg-blue-50 text-blue-600 border-blue-200">
                <Sparkles className="h-4 w-4 mr-2" />
                Handled by Real Experts
              </Badge>
              
              <h1 className="text-5xl md:text-6xl lg:text-7xl font-bold mb-6 text-gray-900 leading-tight">
                Website Issues
                <br />
                <span className="bg-gradient-to-r from-blue-600 to-blue-500 bg-clip-text text-transparent">
                  Fixed by Professionals
                </span>
              </h1>

              <p className="text-xl md:text-2xl text-gray-600 mb-10 max-w-3xl mx-auto leading-relaxed">
                Professional WordPress support from experienced engineers. Get your website fixed fast with transparent pricing and secure access handling.
              </p>

              <div className="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <Button
                  size="lg"
                  onClick={() => onNavigate('fix-an-issue')}
                  className="rounded-full px-8 py-6 text-lg bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 shadow-xl shadow-blue-500/30 group"
                >
                  Get Help Now
                  <ArrowRight className="ml-2 h-5 w-5 group-hover:translate-x-1 transition-transform" />
                </Button>
                <Button
                  size="lg"
                  variant="outline"
                  onClick={() => onNavigate('maintenance')}
                  className="rounded-full px-8 py-6 text-lg border-2"
                >
                  View Maintenance Plans
                </Button>
              </div>
            </motion.div>

            {/* Stats */}
            <div className="grid grid-cols-2 lg:grid-cols-4 gap-6 mt-20">
              {stats.map((stat, index) => (
                <motion.div
                  key={index}
                  initial={{ opacity: 0, y: 20 }}
                  animate={{ opacity: 1, y: 0 }}
                  transition={{ duration: 0.6, delay: 0.1 * index }}
                >
                  <Card className="p-6 text-center hover:shadow-xl transition-all border-gray-200 bg-white">
                    <stat.icon className="h-8 w-8 mx-auto mb-3 text-blue-600" />
                    <div className="text-3xl md:text-4xl font-bold text-gray-900 mb-1">
                      {stat.value}
                    </div>
                    <div className="text-gray-600 text-sm">{stat.label}</div>
                  </Card>
                </motion.div>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* Issues We Solve Section */}
      <section className="py-20 md:py-32 px-4 bg-white">
        <div className="container mx-auto">
          <div className="text-center mb-16">
            <Badge className="mb-6 px-4 py-2 rounded-full bg-blue-50 text-blue-600 border-blue-200">
              Issues We Solve
            </Badge>
            <h2 className="text-4xl md:text-5xl font-bold mb-4 text-gray-900">
              Every WordPress Problem, Fixed
            </h2>
            <p className="text-xl text-gray-600 max-w-3xl mx-auto">
              From critical emergencies to performance optimization, we handle it all
            </p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-7xl mx-auto mb-12">
            {issueCategories.map((category, index) => {
              const colors = getCategoryColor(category.color);
              return (
                <motion.div
                  key={category.name}
                  initial={{ opacity: 0, y: 20 }}
                  animate={{ opacity: 1, y: 0 }}
                  transition={{ duration: 0.6, delay: 0.1 * index }}
                >
                  <Card className="p-6 hover:shadow-xl transition-all border-2 border-gray-200 hover:border-blue-300 bg-white h-full">
                    <div className={`flex h-12 w-12 items-center justify-center rounded-xl ${colors.bg} ${colors.border} border mb-4`}>
                      <category.icon className={`h-6 w-6 ${colors.text}`} />
                    </div>
                    <h3 className="text-xl font-bold mb-3 text-gray-900">{category.name}</h3>
                    <ul className="space-y-2 mb-4">
                      {category.issues.map((issue, idx) => (
                        <li key={idx} className="flex items-start text-sm text-gray-600">
                          <CheckCircle className="h-4 w-4 text-blue-600 mr-2 flex-shrink-0 mt-0.5" />
                          <span>{issue}</span>
                        </li>
                      ))}
                    </ul>
                    <div className="pt-4 border-t border-gray-200">
                      <p className="text-sm text-gray-500">Starting from</p>
                      <p className="text-lg font-bold text-gray-900">{category.priceRange}</p>
                    </div>
                  </Card>
                </motion.div>
              );
            })}
          </div>

          <div className="text-center">
            <Button
              size="lg"
              onClick={() => onNavigate('fix-an-issue')}
              className="rounded-full px-10 py-6 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 shadow-lg"
            >
              View All Issues & Pricing
              <ArrowRight className="ml-2 h-5 w-5" />
            </Button>
          </div>
        </div>
      </section>

      {/* Features Section */}
      <section className="py-20 md:py-32 px-4 bg-gray-50">
        <div className="container mx-auto">
          <div className="text-center mb-16">
            <Badge className="mb-6 px-4 py-2 rounded-full bg-blue-50 text-blue-600 border-blue-200">
              Why Choose Aakaari
            </Badge>
            <h2 className="text-4xl md:text-5xl font-bold mb-4 text-gray-900">
              Professional Support You Can Trust
            </h2>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 max-w-7xl mx-auto">
            {features.map((feature, index) => (
              <motion.div
                key={index}
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.6, delay: 0.1 * index }}
              >
                <Card className="p-6 text-center hover:shadow-xl transition-all border-gray-200 bg-white h-full">
                  <div className="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-600 to-blue-500 shadow-lg shadow-blue-500/30 mx-auto mb-4">
                    <feature.icon className="h-7 w-7 text-white" />
                  </div>
                  <h3 className="text-lg font-bold mb-2 text-gray-900">{feature.title}</h3>
                  <p className="text-sm text-gray-600">{feature.description}</p>
                </Card>
              </motion.div>
            ))}
          </div>

          {/* Global Rules */}
          <div className="mt-16 max-w-4xl mx-auto">
            <Card className="p-8 bg-gradient-to-r from-blue-50 to-blue-100 border-blue-200">
              <h3 className="text-xl font-bold text-gray-900 mb-6 text-center flex items-center justify-center">
                <Star className="h-6 w-6 text-blue-600 mr-2 fill-blue-600" />
                Our Commitment to You
              </h3>
              <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div className="flex items-start">
                  <CheckCircle className="h-5 w-5 text-blue-600 mr-3 flex-shrink-0 mt-0.5" />
                  <div>
                    <p className="font-semibold text-gray-900">Standard = Most Popular</p>
                    <p className="text-sm text-gray-600">Best value with fast turnaround</p>
                  </div>
                </div>
                <div className="flex items-start">
                  <CheckCircle className="h-5 w-5 text-blue-600 mr-3 flex-shrink-0 mt-0.5" />
                  <div>
                    <p className="font-semibold text-gray-900">24/7 Ticket Support</p>
                    <p className="text-sm text-gray-600">Always here when you need us</p>
                  </div>
                </div>
                <div className="flex items-start">
                  <CheckCircle className="h-5 w-5 text-blue-600 mr-3 flex-shrink-0 mt-0.5" />
                  <div>
                    <p className="font-semibold text-gray-900">Secure Credentials</p>
                    <p className="text-sm text-gray-600">Encrypted storage, temporary access</p>
                  </div>
                </div>
                <div className="flex items-start">
                  <CheckCircle className="h-5 w-5 text-blue-600 mr-3 flex-shrink-0 mt-0.5" />
                  <div>
                    <p className="font-semibold text-gray-900">No Hidden Charges</p>
                    <p className="text-sm text-gray-600">Transparent, fixed pricing</p>
                  </div>
                </div>
              </div>
            </Card>
          </div>
        </div>
      </section>

      {/* Testimonials */}
      <section className="py-20 md:py-32 px-4 bg-white">
        <div className="container mx-auto">
          <div className="text-center mb-16">
            <Badge className="mb-6 px-4 py-2 rounded-full bg-blue-50 text-blue-600 border-blue-200">
              Testimonials
            </Badge>
            <h2 className="text-4xl md:text-5xl font-bold mb-4 text-gray-900">
              Trusted by Hundreds
            </h2>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            {testimonials.map((testimonial, index) => (
              <motion.div
                key={index}
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.6, delay: 0.1 * index }}
              >
                <Card className="p-8 hover:shadow-xl transition-all border-gray-200 bg-white h-full">
                  <div className="flex mb-4">
                    {[...Array(testimonial.rating)].map((_, i) => (
                      <Star key={i} className="h-5 w-5 fill-blue-500 text-blue-500" />
                    ))}
                  </div>
                  <p className="text-gray-700 mb-6 leading-relaxed">"{testimonial.content}"</p>
                  <div className="flex items-center">
                    <div className="flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br from-blue-600 to-blue-500 text-white font-bold mr-4">
                      {testimonial.avatar}
                    </div>
                    <div>
                      <p className="font-semibold text-gray-900">{testimonial.name}</p>
                      <p className="text-sm text-gray-600">{testimonial.role}</p>
                    </div>
                  </div>
                </Card>
              </motion.div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-20 md:py-32 px-4 bg-gradient-to-br from-blue-600 to-blue-500">
        <div className="container mx-auto">
          <div className="max-w-4xl mx-auto text-center text-white">
            <Sparkles className="h-16 w-16 mx-auto mb-8" />
            <h2 className="text-4xl md:text-5xl font-bold mb-6">
              Ready to Fix Your Website?
            </h2>
            <p className="text-xl text-blue-50 mb-10 max-w-2xl mx-auto">
              Join hundreds of satisfied clients who trust Aakaari with their website issues. Fast, secure, and transparent.
            </p>
            <Button
              size="lg"
              onClick={() => onNavigate('fix-an-issue')}
              className="rounded-full px-12 py-6 text-lg bg-white text-blue-600 hover:bg-gray-50 shadow-xl"
            >
              Get Started Now
              <ArrowRight className="ml-2 h-5 w-5" />
            </Button>
          </div>
        </div>
      </section>
    </div>
  );
}
