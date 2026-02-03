import { useState } from 'react';
import { Card } from './ui/card';
import { Button } from './ui/button';
import { Input } from './ui/input';
import { Textarea } from './ui/textarea';
import { Label } from './ui/label';
import { Badge } from './ui/badge';
import { Progress } from './ui/progress';
import { motion } from 'motion/react';
import {
  CheckCircle,
  ArrowRight,
  ArrowLeft,
  Server,
  Lock,
  Smartphone,
  Bug,
  Database,
  Mail,
  ShoppingCart,
  AlertTriangle,
  Code2,
  ChevronRight,
  Zap,
  Shield,
  Star,
  Clock,
  DollarSign,
  Settings,
  Globe,
  HardDrive,
  ShieldAlert,
  CreditCard,
  TrendingUp,
  LogIn,
  Layout,
} from 'lucide-react';
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from './ui/select';
import { Checkbox } from './ui/checkbox';

interface FixAnIssuePageProps {
  onNavigate: (page: string) => void;
}

interface IssuePricing {
  basic: { price: string; time: string };
  standard: { price: string; time: string };
  advanced: { price: string; time: string };
  details: {
    basic: string;
    standard: string;
    advanced: string;
  };
}

export function FixAnIssuePage({ onNavigate }: FixAnIssuePageProps) {
  const [step, setStep] = useState(0);
  const [selectedCategory, setSelectedCategory] = useState('');
  const [selectedIssue, setSelectedIssue] = useState('');
  const [selectedTier, setSelectedTier] = useState('');
  const [formData, setFormData] = useState({
    description: '',
    websiteUrl: '',
    urgency: '',
    name: '',
    email: '',
    phone: '',
    agreeToTerms: false,
  });

  const issueCategories = [
    {
      id: 'wordpress-core',
      name: 'WordPress Core Issues',
      icon: Code2,
      color: 'blue',
      issues: [
        {
          id: 'site-down',
          title: 'Website Not Opening / Site Down',
          icon: AlertTriangle,
          pricing: {
            basic: { price: '$19', time: '24h' },
            standard: { price: '$49', time: '8h' },
            advanced: { price: '$99', time: '2h Priority' },
            details: {
              basic: 'Restart services, minor fixes',
              standard: 'Server diagnosis + core repair',
              advanced: 'Full recovery + DB restore',
            },
          },
        },
        {
          id: 'white-screen',
          title: 'White Screen of Death',
          icon: AlertTriangle,
          pricing: {
            basic: { price: '$19', time: '24h' },
            standard: { price: '$39', time: '8h' },
            advanced: { price: '$79', time: '3h Priority' },
            details: {
              basic: 'Single plugin/theme fix',
              standard: 'Log debugging + multi-conflict fix',
              advanced: 'Core + PHP deep repair',
            },
          },
        },
        {
          id: 'plugin-conflict',
          title: 'Plugin Conflict',
          icon: Bug,
          pricing: {
            basic: { price: '$19', time: '24h' },
            standard: { price: '$45', time: '8h' },
            advanced: { price: '$89', time: 'Priority' },
            details: {
              basic: 'Identify & disable plugin',
              standard: 'Patch/replace functionality',
              advanced: 'Custom code solution',
            },
          },
        },
        {
          id: 'forms-not-working',
          title: 'Forms Not Working',
          icon: Mail,
          pricing: {
            basic: { price: '$15', time: '24h' },
            standard: { price: '$35', time: '8h' },
            advanced: { price: '$69', time: 'Priority' },
            details: {
              basic: 'Fix settings + test',
              standard: 'Spam + logic fix',
              advanced: 'CRM / API integration',
            },
          },
        },
      ],
    },
    {
      id: 'infrastructure',
      name: 'Infrastructure & Hosting',
      icon: Server,
      color: 'purple',
      issues: [
        {
          id: '500-error',
          title: '500 Internal Server Error',
          icon: Server,
          pricing: {
            basic: { price: '$19', time: '24h' },
            standard: { price: '$49', time: '8h' },
            advanced: { price: '$89', time: 'Priority' },
            details: {
              basic: 'Basic server restart',
              standard: 'Server log analysis',
              advanced: 'Deep server diagnostics',
            },
          },
        },
        {
          id: 'database-error',
          title: 'Database Connection Error',
          icon: Database,
          pricing: {
            basic: { price: '$19', time: '24h' },
            standard: { price: '$49', time: '8h' },
            advanced: { price: '$99', time: 'Priority' },
            details: {
              basic: 'Connection reset',
              standard: 'Database repair',
              advanced: 'Full DB recovery',
            },
          },
        },
        {
          id: 'email-not-sending',
          title: 'Email Not Sending',
          icon: Mail,
          pricing: {
            basic: { price: '$15', time: '24h' },
            standard: { price: '$29', time: '8h' },
            advanced: { price: '$59', time: 'Priority' },
            details: {
              basic: 'SMTP settings fix',
              standard: 'Email server config',
              advanced: 'Custom email solution',
            },
          },
        },
        {
          id: 'server-config',
          title: 'Server Configuration Issue',
          icon: Settings,
          pricing: {
            basic: { price: '$39', time: '24h' },
            standard: { price: '$79', time: '8h' },
            advanced: { price: '$149', time: 'Priority' },
            details: {
              basic: 'Basic config adjustments',
              standard: 'Full server optimization',
              advanced: 'Custom server setup',
            },
          },
        },
        {
          id: 'dns-domain',
          title: 'DNS / Domain Issue',
          icon: Globe,
          pricing: {
            basic: { price: '$15', time: '24h' },
            standard: { price: '$29', time: '8h' },
            advanced: { price: '$59', time: 'Priority' },
            details: {
              basic: 'DNS record update',
              standard: 'Domain propagation fix',
              advanced: 'Complex DNS setup',
            },
          },
        },
        {
          id: 'backup-migration',
          title: 'Backup / Migration',
          icon: HardDrive,
          pricing: {
            basic: { price: '$29', time: '24h' },
            standard: { price: '$59', time: '8h' },
            advanced: { price: '$99', time: 'Priority' },
            details: {
              basic: 'Simple backup/restore',
              standard: 'Full site migration',
              advanced: 'Complex migration + optimization',
            },
          },
        },
      ],
    },
    {
      id: 'security',
      name: 'Security & Hacking',
      icon: Lock,
      color: 'red',
      issues: [
        {
          id: 'hacked-malware',
          title: 'Website Hacked / Malware',
          icon: ShieldAlert,
          pricing: {
            basic: { price: '$39', time: '24h' },
            standard: { price: '$79', time: '8h' },
            advanced: { price: '$149', time: 'Priority' },
            details: {
              basic: 'Basic malware scan & removal',
              standard: 'Deep cleaning + security patch',
              advanced: 'Full forensic analysis + hardening',
            },
          },
        },
        {
          id: 'virus-spam',
          title: 'Virus / Spam Injection',
          icon: Bug,
          pricing: {
            basic: { price: '$29', time: '24h' },
            standard: { price: '$59', time: '8h' },
            advanced: { price: '$99', time: 'Priority' },
            details: {
              basic: 'Remove spam content',
              standard: 'Clean + secure',
              advanced: 'Full site sanitization',
            },
          },
        },
        {
          id: 'redirect-hack',
          title: 'Redirect Hack',
          icon: AlertTriangle,
          pricing: {
            basic: { price: '$29', time: '24h' },
            standard: { price: '$49', time: '8h' },
            advanced: { price: '$89', time: 'Priority' },
            details: {
              basic: 'Remove redirect code',
              standard: 'Find & fix source',
              advanced: 'Complete security audit',
            },
          },
        },
        {
          id: 'ssl-error',
          title: 'SSL Error',
          icon: Lock,
          pricing: {
            basic: { price: '$15', time: '24h' },
            standard: { price: '$29', time: '8h' },
            advanced: { price: '$59', time: 'Priority' },
            details: {
              basic: 'SSL certificate renewal',
              standard: 'Fix HTTPS issues',
              advanced: 'Custom SSL setup',
            },
          },
        },
        {
          id: 'mixed-content',
          title: 'Mixed Content',
          icon: Shield,
          pricing: {
            basic: { price: '$15', time: '24h' },
            standard: { price: '$25', time: '8h' },
            advanced: { price: '$49', time: 'Priority' },
            details: {
              basic: 'Fix obvious HTTP links',
              standard: 'Scan & fix all content',
              advanced: 'Deep content security',
            },
          },
        },
      ],
    },
    {
      id: 'woocommerce',
      name: 'WooCommerce & eCommerce',
      icon: ShoppingCart,
      color: 'green',
      issues: [
        {
          id: 'payment-gateway',
          title: 'Payment Gateway',
          icon: CreditCard,
          pricing: {
            basic: { price: '$39', time: '24h' },
            standard: { price: '$79', time: '8h' },
            advanced: { price: '$149', time: 'Priority' },
            details: {
              basic: 'Basic gateway setup',
              standard: 'Multi-gateway config',
              advanced: 'Custom payment integration',
            },
          },
        },
        {
          id: 'checkout-issue',
          title: 'Checkout Issue',
          icon: ShoppingCart,
          pricing: {
            basic: { price: '$29', time: '24h' },
            standard: { price: '$59', time: '8h' },
            advanced: { price: '$99', time: 'Priority' },
            details: {
              basic: 'Fix checkout errors',
              standard: 'Optimize checkout flow',
              advanced: 'Custom checkout solution',
            },
          },
        },
        {
          id: 'order-not-processing',
          title: 'Order Not Processing',
          icon: AlertTriangle,
          pricing: {
            basic: { price: '$25', time: '24h' },
            standard: { price: '$55', time: '8h' },
            advanced: { price: '$95', time: 'Priority' },
            details: {
              basic: 'Fix order flow',
              standard: 'Debug & repair',
              advanced: 'Complete order system fix',
            },
          },
        },
      ],
    },
    {
      id: 'performance',
      name: 'Performance Optimization',
      icon: Zap,
      color: 'yellow',
      issues: [
        {
          id: 'slow-website',
          title: 'Slow Website',
          icon: TrendingUp,
          pricing: {
            basic: { price: '$29', time: '24h' },
            standard: { price: '$59', time: '8h' },
            advanced: { price: '$99', time: 'Priority' },
            details: {
              basic: 'Basic caching setup',
              standard: 'Full speed optimization',
              advanced: 'Advanced performance tuning',
            },
          },
        },
        {
          id: 'core-web-vitals',
          title: 'Core Web Vitals',
          icon: TrendingUp,
          pricing: {
            basic: { price: '$35', time: '24h' },
            standard: { price: '$69', time: '8h' },
            advanced: { price: '$119', time: 'Priority' },
            details: {
              basic: 'Improve key metrics',
              standard: 'Full CWV optimization',
              advanced: 'Expert performance audit',
            },
          },
        },
        {
          id: 'mobile-responsive',
          title: 'Mobile Responsive',
          icon: Smartphone,
          pricing: {
            basic: { price: '$19', time: '24h' },
            standard: { price: '$39', time: '8h' },
            advanced: { price: '$79', time: 'Priority' },
            details: {
              basic: 'Fix major mobile issues',
              standard: 'Full mobile optimization',
              advanced: 'Custom responsive design',
            },
          },
        },
      ],
    },
    {
      id: 'authentication',
      name: 'Authentication & Access',
      icon: LogIn,
      color: 'indigo',
      issues: [
        {
          id: 'login-not-working',
          title: 'Login Not Working',
          icon: LogIn,
          pricing: {
            basic: { price: '$15', time: '24h' },
            standard: { price: '$29', time: '8h' },
            advanced: { price: '$59', time: 'Priority' },
            details: {
              basic: 'Reset login system',
              standard: 'Fix authentication',
              advanced: 'Custom login solution',
            },
          },
        },
        {
          id: 'admin-not-accessible',
          title: 'Admin Panel Not Accessible',
          icon: Shield,
          pricing: {
            basic: { price: '$19', time: '24h' },
            standard: { price: '$39', time: '8h' },
            advanced: { price: '$79', time: 'Priority' },
            details: {
              basic: 'Restore admin access',
              standard: 'Fix admin issues',
              advanced: 'Complete admin recovery',
            },
          },
        },
      ],
    },
    {
      id: 'design-layout',
      name: 'Design & Layout',
      icon: Layout,
      color: 'pink',
      issues: [
        {
          id: 'theme-broken',
          title: 'Theme / Layout Broken',
          icon: Layout,
          pricing: {
            basic: { price: '$19', time: '24h' },
            standard: { price: '$45', time: '8h' },
            advanced: { price: '$85', time: 'Priority' },
            details: {
              basic: 'Fix basic layout issues',
              standard: 'Full theme repair',
              advanced: 'Custom theme fix + optimization',
            },
          },
        },
      ],
    },
  ];

  const totalSteps = 4;
  const progress = step === 0 ? 0 : (step / totalSteps) * 100;

  const handleNext = () => {
    if (step < totalSteps) {
      setStep(step + 1);
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }
  };

  const handleBack = () => {
    if (step > 0) {
      setStep(step - 1);
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }
  };

  const handleCategorySelect = (categoryId: string) => {
    setSelectedCategory(categoryId);
  };

  const handleIssueSelect = (issueId: string) => {
    setSelectedIssue(issueId);
    setStep(1);
    window.scrollTo({ top: 0, behavior: 'smooth' });
  };

  const getCategoryColor = (color: string) => {
    const colors: Record<string, string> = {
      blue: 'bg-blue-50 text-blue-600 border-blue-200',
      purple: 'bg-purple-50 text-purple-600 border-purple-200',
      red: 'bg-red-50 text-red-600 border-red-200',
      green: 'bg-emerald-50 text-emerald-600 border-emerald-200',
      yellow: 'bg-yellow-50 text-yellow-600 border-yellow-200',
      indigo: 'bg-indigo-50 text-indigo-600 border-indigo-200',
      pink: 'bg-pink-50 text-pink-600 border-pink-200',
    };
    return colors[color] || colors.blue;
  };

  const renderStepContent = () => {
    if (step === 0) {
      const filteredCategories = selectedCategory
        ? issueCategories.filter((cat) => cat.id === selectedCategory)
        : issueCategories;

      return (
        <div className="space-y-8">
          <div className="text-center mb-12">
            <Badge className="mb-6 px-4 py-2 rounded-full bg-blue-50 text-blue-600 border-blue-200">
              Select Your Issue
            </Badge>
            <h2 className="text-4xl md:text-5xl font-bold mb-4 text-gray-900">
              What Needs Fixing?
            </h2>
            <p className="text-gray-600 text-lg">
              Choose the category and issue you're experiencing
            </p>
          </div>

          {/* Category Filter */}
          {!selectedCategory && (
            <div className="flex flex-wrap justify-center gap-3 mb-12">
              {issueCategories.map((category) => (
                <Button
                  key={category.id}
                  variant="outline"
                  onClick={() => handleCategorySelect(category.id)}
                  className="rounded-full border-2"
                >
                  <category.icon className="h-4 w-4 mr-2" />
                  {category.name}
                </Button>
              ))}
            </div>
          )}

          {selectedCategory && (
            <div className="text-center mb-8">
              <Button
                variant="outline"
                onClick={() => setSelectedCategory('')}
                className="rounded-full"
              >
                <ArrowLeft className="h-4 w-4 mr-2" />
                View All Categories
              </Button>
            </div>
          )}

          {/* Issues by Category */}
          <div className="space-y-12 max-w-7xl mx-auto">
            {filteredCategories.map((category) => (
              <div key={category.id}>
                <div className="flex items-center gap-3 mb-6">
                  <div className={`flex h-10 w-10 items-center justify-center rounded-xl ${getCategoryColor(category.color)}`}>
                    <category.icon className="h-5 w-5" />
                  </div>
                  <h3 className="text-2xl font-bold text-gray-900">{category.name}</h3>
                </div>

                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                  {category.issues.map((issue, index) => (
                    <motion.div
                      key={issue.id}
                      initial={{ opacity: 0, y: 20 }}
                      animate={{ opacity: 1, y: 0 }}
                      transition={{ duration: 0.3, delay: index * 0.05 }}
                    >
                      <Card
                        onClick={() => handleIssueSelect(issue.id)}
                        className="group p-6 cursor-pointer transition-all hover:shadow-xl border-2 border-gray-200 hover:border-blue-500 bg-white"
                      >
                        <div className="flex items-start justify-between mb-4">
                          <div className="flex items-center gap-3">
                            <div className="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 group-hover:bg-blue-100 transition-colors">
                              <issue.icon className="h-5 w-5 text-blue-600" />
                            </div>
                            <h4 className="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                              {issue.title}
                            </h4>
                          </div>
                        </div>

                        <div className="space-y-3 mb-4">
                          <div className="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                            <div>
                              <span className="text-xs text-gray-500">Basic</span>
                              <p className="text-sm font-semibold text-gray-900">{issue.pricing.basic.price}</p>
                            </div>
                            <Badge variant="outline" className="text-xs">{issue.pricing.basic.time}</Badge>
                          </div>
                          <div className="flex items-center justify-between p-2 bg-blue-50 rounded-lg border border-blue-200">
                            <div>
                              <div className="flex items-center gap-1">
                                <span className="text-xs text-blue-600 font-medium">Standard</span>
                                <Star className="h-3 w-3 text-blue-600 fill-blue-600" />
                              </div>
                              <p className="text-sm font-semibold text-gray-900">{issue.pricing.standard.price}</p>
                            </div>
                            <Badge className="text-xs bg-blue-600 text-white">{issue.pricing.standard.time}</Badge>
                          </div>
                          <div className="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                            <div>
                              <span className="text-xs text-gray-500">Advanced</span>
                              <p className="text-sm font-semibold text-gray-900">{issue.pricing.advanced.price}</p>
                            </div>
                            <Badge variant="outline" className="text-xs">{issue.pricing.advanced.time}</Badge>
                          </div>
                        </div>

                        <div className="flex items-center text-blue-600 text-sm font-medium opacity-0 group-hover:opacity-100 transition-opacity">
                          Select Issue
                          <ChevronRight className="h-4 w-4 ml-1 group-hover:translate-x-1 transition-transform" />
                        </div>
                      </Card>
                    </motion.div>
                  ))}
                </div>
              </div>
            ))}
          </div>
        </div>
      );
    }

    // Find selected issue
    let selectedIssueData: any = null;
    let selectedIssuePricing: IssuePricing | null = null;

    for (const category of issueCategories) {
      const issue = category.issues.find((i) => i.id === selectedIssue);
      if (issue) {
        selectedIssueData = issue;
        selectedIssuePricing = issue.pricing;
        break;
      }
    }

    switch (step) {
      case 1:
        return (
          <div className="space-y-8">
            <div className="text-center mb-12">
              <Badge className="mb-6 px-4 py-2 rounded-full bg-blue-50 text-blue-600 border-blue-200">
                Step 1 of {totalSteps}
              </Badge>
              <h2 className="text-4xl md:text-5xl font-bold mb-4 text-gray-900">
                Choose Service Tier
              </h2>
              <p className="text-gray-600 text-lg mb-2">
                {selectedIssueData?.title}
              </p>
              <p className="text-sm text-gray-500">
                ⭐ Standard = Most Popular | 24/7 Ticket Support | Secure Credential Handling
              </p>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto">
              {selectedIssuePricing && ['basic', 'standard', 'advanced'].map((tier) => {
                const tierKey = tier as 'basic' | 'standard' | 'advanced';
                const pricing = selectedIssuePricing[tierKey];
                const details = selectedIssuePricing.details[tierKey];
                const isStandard = tier === 'standard';

                return (
                  <motion.div
                    key={tier}
                    initial={{ opacity: 0, y: 20 }}
                    animate={{ opacity: 1, y: 0 }}
                    whileHover={{ scale: 1.02 }}
                    transition={{ duration: 0.3 }}
                  >
                    {isStandard && (
                      <div className="text-center mb-3">
                        <Badge className="px-4 py-1 rounded-full bg-gradient-to-r from-blue-600 to-blue-500 text-white border-0">
                          <Star className="h-3 w-3 mr-1" />
                          Most Popular
                        </Badge>
                      </div>
                    )}

                    <Card
                      onClick={() => setSelectedTier(tier)}
                      className={`p-8 cursor-pointer transition-all border-2 ${
                        selectedTier === tier
                          ? 'border-blue-500 shadow-xl shadow-blue-500/20 bg-blue-50'
                          : 'border-gray-200 hover:border-blue-300 bg-white'
                      }`}
                    >
                      <div className="mb-6">
                        <h3 className="text-2xl font-bold mb-2 text-gray-900 capitalize">{tier}</h3>
                        <div className="flex items-baseline gap-2 mb-2">
                          <span className="text-4xl font-bold text-gray-900">{pricing.price}</span>
                          <Badge variant="outline" className="text-xs">{pricing.time}</Badge>
                        </div>
                      </div>

                      <div className="space-y-3 mb-6">
                        <div className="flex items-start">
                          <CheckCircle className="h-5 w-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" />
                          <span className="text-sm text-gray-700">{details}</span>
                        </div>
                        <div className="flex items-start">
                          <CheckCircle className="h-5 w-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" />
                          <span className="text-sm text-gray-600">24/7 ticket support</span>
                        </div>
                        <div className="flex items-start">
                          <CheckCircle className="h-5 w-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" />
                          <span className="text-sm text-gray-600">Secure credential handling</span>
                        </div>
                        {tier === 'advanced' && (
                          <div className="flex items-start">
                            <CheckCircle className="h-5 w-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" />
                            <span className="text-sm text-gray-600">Money-back guarantee</span>
                          </div>
                        )}
                      </div>

                      {selectedTier === tier && (
                        <div className="flex items-center justify-center text-blue-600 font-medium">
                          <CheckCircle className="h-5 w-5 mr-2" />
                          <span>Selected</span>
                        </div>
                      )}
                    </Card>
                  </motion.div>
                );
              })}
            </div>

            <div className="max-w-4xl mx-auto mt-12">
              <Card className="p-6 bg-blue-50 border-blue-200">
                <h4 className="font-semibold text-gray-900 mb-4 flex items-center">
                  <Shield className="h-5 w-5 mr-2 text-blue-600" />
                  How We Access Your Website
                </h4>
                <ul className="space-y-3 text-sm text-gray-700">
                  <li className="flex items-start">
                    <CheckCircle className="h-4 w-4 text-blue-600 mr-2 flex-shrink-0 mt-0.5" />
                    <span><strong>Secure Access Management:</strong> We use encrypted credential storage and never store your passwords in plain text</span>
                  </li>
                  <li className="flex items-start">
                    <CheckCircle className="h-4 w-4 text-blue-600 mr-2 flex-shrink-0 mt-0.5" />
                    <span><strong>Multiple Access Options:</strong> Provide cPanel, FTP, WordPress admin, or hosting provider access</span>
                  </li>
                  <li className="flex items-start">
                    <CheckCircle className="h-4 w-4 text-blue-600 mr-2 flex-shrink-0 mt-0.5" />
                    <span><strong>Temporary Access:</strong> We create temporary admin accounts that are removed after the fix</span>
                  </li>
                  <li className="flex items-start">
                    <CheckCircle className="h-4 w-4 text-blue-600 mr-2 flex-shrink-0 mt-0.5" />
                    <span><strong>Change Passwords:</strong> You can change your passwords immediately after we complete the work</span>
                  </li>
                </ul>
              </Card>
            </div>
          </div>
        );

      case 2:
        return (
          <div className="max-w-2xl mx-auto space-y-8">
            <div className="text-center mb-8">
              <Badge className="mb-6 px-4 py-2 rounded-full bg-blue-50 text-blue-600 border-blue-200">
                Step 2 of {totalSteps}
              </Badge>
              <h2 className="text-4xl font-bold mb-4 text-gray-900">Describe Your Issue</h2>
              <p className="text-gray-600">
                Tell us what's happening with your website
              </p>
            </div>

            <Card className="p-8 border-2 border-gray-200 bg-white">
              <div className="space-y-6">
                <div className="space-y-2">
                  <Label htmlFor="description">What's happening?</Label>
                  <Textarea
                    id="description"
                    placeholder="Describe the problem in detail..."
                    rows={8}
                    value={formData.description}
                    onChange={(e) =>
                      setFormData({ ...formData, description: e.target.value })
                    }
                    className="border-gray-300"
                  />
                </div>

                <div className="space-y-2">
                  <Label htmlFor="urgency">Urgency Level</Label>
                  <Select
                    value={formData.urgency}
                    onValueChange={(value) =>
                      setFormData({ ...formData, urgency: value })
                    }
                  >
                    <SelectTrigger className="border-gray-300">
                      <SelectValue placeholder="Select urgency" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectItem value="critical">Critical - Site is down</SelectItem>
                      <SelectItem value="high">High - Major issues</SelectItem>
                      <SelectItem value="medium">Medium - Some problems</SelectItem>
                      <SelectItem value="low">Low - Minor issues</SelectItem>
                    </SelectContent>
                  </Select>
                </div>
              </div>
            </Card>
          </div>
        );

      case 3:
        return (
          <div className="max-w-2xl mx-auto space-y-8">
            <div className="text-center mb-8">
              <Badge className="mb-6 px-4 py-2 rounded-full bg-blue-50 text-blue-600 border-blue-200">
                Step 3 of {totalSteps}
              </Badge>
              <h2 className="text-4xl font-bold mb-4 text-gray-900">Your Details</h2>
              <p className="text-gray-600">
                How can we reach you?
              </p>
            </div>

            <Card className="p-8 border-2 border-gray-200 bg-white">
              <div className="space-y-6">
                <div className="space-y-2">
                  <Label htmlFor="websiteUrl">Website URL</Label>
                  <Input
                    id="websiteUrl"
                    type="url"
                    placeholder="https://yourwebsite.com"
                    value={formData.websiteUrl}
                    onChange={(e) =>
                      setFormData({ ...formData, websiteUrl: e.target.value })
                    }
                    className="border-gray-300"
                  />
                </div>

                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div className="space-y-2">
                    <Label htmlFor="name">Full Name</Label>
                    <Input
                      id="name"
                      placeholder="John Doe"
                      value={formData.name}
                      onChange={(e) =>
                        setFormData({ ...formData, name: e.target.value })
                      }
                      className="border-gray-300"
                    />
                  </div>
                  <div className="space-y-2">
                    <Label htmlFor="phone">Phone Number</Label>
                    <Input
                      id="phone"
                      type="tel"
                      placeholder="+1 (555) 000-0000"
                      value={formData.phone}
                      onChange={(e) =>
                        setFormData({ ...formData, phone: e.target.value })
                      }
                      className="border-gray-300"
                    />
                  </div>
                </div>

                <div className="space-y-2">
                  <Label htmlFor="email">Email Address</Label>
                  <Input
                    id="email"
                    type="email"
                    placeholder="john@example.com"
                    value={formData.email}
                    onChange={(e) =>
                      setFormData({ ...formData, email: e.target.value })
                    }
                    className="border-gray-300"
                  />
                </div>
              </div>
            </Card>
          </div>
        );

      case 4:
        const selectedTierPricing = selectedIssuePricing?.[selectedTier as 'basic' | 'standard' | 'advanced'];
        
        return (
          <div className="max-w-2xl mx-auto space-y-8">
            <div className="text-center mb-8">
              <Badge className="mb-6 px-4 py-2 rounded-full bg-blue-50 text-blue-600 border-blue-200">
                Step 4 of {totalSteps}
              </Badge>
              <h2 className="text-4xl font-bold mb-4 text-gray-900">Review & Submit</h2>
              <p className="text-gray-600">
                Confirm your details and proceed to payment
              </p>
            </div>

            <Card className="p-8 border-2 border-gray-200 bg-white">
              <div className="space-y-6">
                <div>
                  <h3 className="text-lg font-semibold mb-4 text-gray-900">Order Summary</h3>
                  <div className="space-y-3 pb-4 border-b border-gray-200">
                    <div className="flex justify-between text-sm">
                      <span className="text-gray-600">Issue:</span>
                      <span className="font-medium text-gray-900">{selectedIssueData?.title}</span>
                    </div>
                    <div className="flex justify-between text-sm">
                      <span className="text-gray-600">Service Tier:</span>
                      <span className="font-medium text-gray-900 capitalize">{selectedTier}</span>
                    </div>
                    <div className="flex justify-between text-sm">
                      <span className="text-gray-600">Response Time:</span>
                      <span className="font-medium text-gray-900">{selectedTierPricing?.time}</span>
                    </div>
                    <div className="flex justify-between text-sm">
                      <span className="text-gray-600">Price:</span>
                      <span className="font-medium text-gray-900">{selectedTierPricing?.price}</span>
                    </div>
                  </div>
                  <div className="flex justify-between pt-4 text-xl font-bold">
                    <span className="text-gray-900">Total:</span>
                    <span className="text-blue-600">{selectedTierPricing?.price}</span>
                  </div>
                </div>

                <div className="flex items-start space-x-3 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                  <Checkbox
                    id="terms"
                    checked={formData.agreeToTerms}
                    onCheckedChange={(checked) =>
                      setFormData({ ...formData, agreeToTerms: checked as boolean })
                    }
                  />
                  <label
                    htmlFor="terms"
                    className="text-sm leading-relaxed cursor-pointer text-gray-700"
                  >
                    I agree to the Terms of Service and Privacy Policy. I authorize Aakaari to securely access my website for repair purposes. I understand that no hidden charges will be applied.
                  </label>
                </div>

                <Button
                  onClick={() => onNavigate('checkout')}
                  disabled={!formData.agreeToTerms}
                  className="w-full rounded-full py-6 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 shadow-lg shadow-blue-500/30"
                >
                  Proceed to Payment
                  <ArrowRight className="ml-2 h-5 w-5" />
                </Button>
              </div>
            </Card>
          </div>
        );

      default:
        return null;
    }
  };

  return (
    <div className="w-full pt-32 pb-20 px-4 min-h-screen bg-gradient-to-b from-gray-50 to-white">
      <div className="container mx-auto">
        {/* Progress */}
        {step > 0 && (
          <div className="max-w-2xl mx-auto mb-12">
            <Progress value={progress} className="h-2" />
          </div>
        )}

        {/* Content */}
        {renderStepContent()}

        {/* Navigation */}
        {step > 0 && (
          <div className="max-w-2xl mx-auto mt-12 flex justify-between">
            <Button
              variant="outline"
              onClick={handleBack}
              className="rounded-full px-8 border-2"
            >
              <ArrowLeft className="mr-2 h-4 w-4" />
              Back
            </Button>
            {step < totalSteps && (
              <Button
                onClick={handleNext}
                className="ml-auto rounded-full px-8 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600"
                disabled={step === 1 && !selectedTier}
              >
                Continue
                <ArrowRight className="ml-2 h-4 w-4" />
              </Button>
            )}
          </div>
        )}
      </div>
    </div>
  );
}
