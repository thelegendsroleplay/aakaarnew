import { Card, CardContent, CardDescription, CardHeader, CardTitle } from './ui/card';
import { Button } from './ui/button';
import { Input } from './ui/input';
import { Textarea } from './ui/textarea';
import { Label } from './ui/label';
import { Badge } from './ui/badge';
import {
  Code,
  Palette,
  ShoppingCart,
  Zap,
  Globe,
  CheckCircle,
  ArrowRight,
  Users,
  Clock,
  Shield,
} from 'lucide-react';
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from './ui/select';

interface BuildSolutionsPageProps {
  onNavigate: (page: string) => void;
}

export function BuildSolutionsPage({ onNavigate }: BuildSolutionsPageProps) {
  const services = [
    {
      icon: Globe,
      title: 'Custom WordPress Website',
      description:
        'Fully custom designed and developed WordPress website tailored to your business',
      features: [
        'Custom design & development',
        'Responsive mobile-first design',
        'SEO optimization',
        'Content migration',
        'Training & documentation',
      ],
      timeline: '4-6 weeks',
      startingPrice: '$3,500',
    },
    {
      icon: ShoppingCart,
      title: 'WooCommerce Store',
      description:
        'Complete e-commerce solution with payment gateway integration',
      features: [
        'Product catalog setup',
        'Payment gateway integration',
        'Shipping configuration',
        'Inventory management',
        'Order tracking system',
      ],
      timeline: '6-8 weeks',
      startingPrice: '$5,000',
    },
    {
      icon: Palette,
      title: 'Theme Customization',
      description:
        'Customize an existing theme to match your brand identity',
      features: [
        'Visual design customization',
        'Brand color integration',
        'Custom page layouts',
        'Plugin configuration',
        'Performance optimization',
      ],
      timeline: '2-3 weeks',
      startingPrice: '$1,500',
    },
    {
      icon: Code,
      title: 'Plugin Development',
      description:
        'Custom WordPress plugin development for unique functionality',
      features: [
        'Custom functionality',
        'Database integration',
        'Admin interface',
        'Documentation',
        'Ongoing support',
      ],
      timeline: '3-5 weeks',
      startingPrice: '$2,500',
    },
    {
      icon: Zap,
      title: 'Website Migration',
      description:
        'Safely migrate your website to a new host or platform',
      features: [
        'Complete site migration',
        'Database transfer',
        'Domain & DNS setup',
        'SSL certificate',
        'Post-migration testing',
      ],
      timeline: '1-2 weeks',
      startingPrice: '$500',
    },
    {
      icon: Users,
      title: 'Website Redesign',
      description:
        'Modernize your existing website with a fresh new design',
      features: [
        'Modern UI/UX design',
        'Content restructuring',
        'Performance optimization',
        'Mobile responsiveness',
        'SEO improvements',
      ],
      timeline: '4-6 weeks',
      startingPrice: '$3,000',
    },
  ];

  const process = [
    {
      step: '1',
      title: 'Discovery Call',
      description: 'We discuss your requirements, goals, and vision for the project',
    },
    {
      step: '2',
      title: 'Proposal & Quote',
      description: 'Receive detailed project scope, timeline, and pricing',
    },
    {
      step: '3',
      title: 'Design Phase',
      description: 'Review mockups and provide feedback until you\'re satisfied',
    },
    {
      step: '4',
      title: 'Development',
      description: 'Our engineers build your site with regular progress updates',
    },
    {
      step: '5',
      title: 'Testing & Launch',
      description: 'Thorough testing followed by launch and handover',
    },
  ];

  const portfolio = [
    {
      title: 'E-commerce Fashion Store',
      category: 'WooCommerce',
      description: 'Custom online store with 5,000+ products',
    },
    {
      title: 'Corporate Website',
      category: 'Business',
      description: 'Professional site for B2B consulting firm',
    },
    {
      title: 'Restaurant Directory',
      category: 'Custom Development',
      description: 'Location-based directory with booking system',
    },
    {
      title: 'Membership Platform',
      category: 'Community',
      description: 'Subscription-based content platform',
    },
  ];

  const techStack = [
    'WordPress 6.x',
    'WooCommerce',
    'Elementor Pro',
    'Advanced Custom Fields',
    'WP Rocket',
    'Yoast SEO',
    'Contact Form 7',
    'PHP 8.x',
    'MySQL',
    'Redis',
  ];

  return (
    <div className="w-full py-12">
      <div className="container mx-auto px-4">
        {/* Header */}
        <div className="max-w-3xl mx-auto text-center mb-12">
          <Badge className="mb-4" variant="secondary">
            Custom Development
          </Badge>
          <h1 className="text-4xl md:text-5xl mb-4">Build Solutions</h1>
          <p className="text-lg text-muted-foreground">
            Professional WordPress development services. From custom websites to
            complex e-commerce platforms, we bring your vision to life.
          </p>
        </div>

        {/* Services Grid */}
        <section className="mb-20">
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
            {services.map((service, index) => (
              <Card key={index} className="hover:shadow-lg transition-shadow">
                <CardHeader>
                  <div className="flex h-12 w-12 items-center justify-center rounded-lg bg-primary/10 mb-4">
                    <service.icon className="h-6 w-6 text-primary" />
                  </div>
                  <CardTitle>{service.title}</CardTitle>
                  <CardDescription>{service.description}</CardDescription>
                </CardHeader>
                <CardContent>
                  <div className="space-y-3 mb-4">
                    {service.features.map((feature, idx) => (
                      <div key={idx} className="flex items-start">
                        <CheckCircle className="h-4 w-4 text-primary mr-2 flex-shrink-0 mt-0.5" />
                        <span className="text-sm">{feature}</span>
                      </div>
                    ))}
                  </div>
                  <div className="flex items-center justify-between pt-4 border-t">
                    <div>
                      <p className="text-sm text-muted-foreground">Starting at</p>
                      <p className="font-bold text-primary">
                        {service.startingPrice}
                      </p>
                    </div>
                    <div className="text-right">
                      <p className="text-sm text-muted-foreground">Timeline</p>
                      <p className="text-sm font-medium">{service.timeline}</p>
                    </div>
                  </div>
                </CardContent>
              </Card>
            ))}
          </div>
        </section>

        {/* Process Timeline */}
        <section className="py-20 bg-muted/30 -mx-4 px-4">
          <div className="max-w-7xl mx-auto">
            <div className="text-center mb-12">
              <h2 className="text-3xl mb-2">Our Development Process</h2>
              <p className="text-muted-foreground">
                A proven workflow that delivers results
              </p>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-5 gap-6">
              {process.map((step, index) => (
                <div key={index} className="text-center">
                  <div className="flex items-center justify-center mb-4">
                    <div className="flex h-16 w-16 items-center justify-center rounded-full bg-primary text-white text-2xl font-bold">
                      {step.step}
                    </div>
                  </div>
                  <h3 className="mb-2">{step.title}</h3>
                  <p className="text-sm text-muted-foreground">
                    {step.description}
                  </p>
                </div>
              ))}
            </div>
          </div>
        </section>

        {/* Request Quote Form */}
        <section className="mt-20 max-w-4xl mx-auto">
          <Card>
            <CardHeader>
              <CardTitle>Request a Custom Quote</CardTitle>
              <CardDescription>
                Tell us about your project and we'll get back to you within 24
                hours with a detailed proposal.
              </CardDescription>
            </CardHeader>
            <CardContent>
              <form className="space-y-6">
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div className="space-y-2">
                    <Label htmlFor="name">Name</Label>
                    <Input id="name" placeholder="John Doe" />
                  </div>
                  <div className="space-y-2">
                    <Label htmlFor="email">Email</Label>
                    <Input id="email" type="email" placeholder="john@example.com" />
                  </div>
                </div>

                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div className="space-y-2">
                    <Label htmlFor="phone">Phone Number</Label>
                    <Input id="phone" type="tel" placeholder="+1 (555) 000-0000" />
                  </div>
                  <div className="space-y-2">
                    <Label htmlFor="website">Current Website (if any)</Label>
                    <Input
                      id="website"
                      type="url"
                      placeholder="https://yourwebsite.com"
                    />
                  </div>
                </div>

                <div className="space-y-2">
                  <Label htmlFor="serviceType">Type of Service</Label>
                  <Select>
                    <SelectTrigger>
                      <SelectValue placeholder="Select service type" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectItem value="custom-website">
                        Custom WordPress Website
                      </SelectItem>
                      <SelectItem value="woocommerce">
                        WooCommerce Store
                      </SelectItem>
                      <SelectItem value="theme-customization">
                        Theme Customization
                      </SelectItem>
                      <SelectItem value="plugin-development">
                        Plugin Development
                      </SelectItem>
                      <SelectItem value="migration">Website Migration</SelectItem>
                      <SelectItem value="redesign">Website Redesign</SelectItem>
                      <SelectItem value="other">Other</SelectItem>
                    </SelectContent>
                  </Select>
                </div>

                <div className="space-y-2">
                  <Label htmlFor="budget">Budget Range</Label>
                  <Select>
                    <SelectTrigger>
                      <SelectValue placeholder="Select budget range" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectItem value="under-2k">Under $2,000</SelectItem>
                      <SelectItem value="2k-5k">$2,000 - $5,000</SelectItem>
                      <SelectItem value="5k-10k">$5,000 - $10,000</SelectItem>
                      <SelectItem value="10k-20k">$10,000 - $20,000</SelectItem>
                      <SelectItem value="20k-plus">$20,000+</SelectItem>
                    </SelectContent>
                  </Select>
                </div>

                <div className="space-y-2">
                  <Label htmlFor="timeline">Desired Timeline</Label>
                  <Select>
                    <SelectTrigger>
                      <SelectValue placeholder="When do you need this?" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectItem value="urgent">ASAP (1-2 weeks)</SelectItem>
                      <SelectItem value="soon">Soon (1 month)</SelectItem>
                      <SelectItem value="flexible">Flexible (2-3 months)</SelectItem>
                      <SelectItem value="planning">Just planning</SelectItem>
                    </SelectContent>
                  </Select>
                </div>

                <div className="space-y-2">
                  <Label htmlFor="projectDetails">Project Details</Label>
                  <Textarea
                    id="projectDetails"
                    placeholder="Tell us about your project requirements, goals, and any specific features you need..."
                    rows={6}
                  />
                </div>

                <Button type="submit" size="lg" className="w-full">
                  Submit Quote Request
                  <ArrowRight className="ml-2 h-4 w-4" />
                </Button>
              </form>
            </CardContent>
          </Card>
        </section>

        {/* Portfolio Preview */}
        <section className="mt-20">
          <div className="text-center mb-8">
            <h2 className="text-3xl mb-2">Recent Projects</h2>
            <p className="text-muted-foreground">
              See what we've built for our clients
            </p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 max-w-7xl mx-auto">
            {portfolio.map((project, index) => (
              <Card key={index} className="hover:shadow-lg transition-shadow">
                <CardContent className="p-6">
                  <Badge variant="secondary" className="mb-3">
                    {project.category}
                  </Badge>
                  <h4 className="mb-2">{project.title}</h4>
                  <p className="text-sm text-muted-foreground">
                    {project.description}
                  </p>
                </CardContent>
              </Card>
            ))}
          </div>
        </section>

        {/* Tech Stack */}
        <section className="mt-20 max-w-5xl mx-auto">
          <div className="text-center mb-8">
            <h2 className="text-3xl mb-2">Our Technology Stack</h2>
            <p className="text-muted-foreground">
              We use industry-leading tools and technologies
            </p>
          </div>

          <Card>
            <CardContent className="p-8">
              <div className="flex flex-wrap gap-3 justify-center">
                {techStack.map((tech, index) => (
                  <Badge key={index} variant="outline" className="text-sm">
                    {tech}
                  </Badge>
                ))}
              </div>
            </CardContent>
          </Card>
        </section>

        {/* Why Choose Us */}
        <section className="mt-20">
          <div className="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            <Card>
              <CardContent className="p-6 text-center">
                <Clock className="h-12 w-12 text-primary mx-auto mb-4" />
                <h3 className="mb-2">On-Time Delivery</h3>
                <p className="text-sm text-muted-foreground">
                  We stick to timelines and keep you updated every step of the way
                </p>
              </CardContent>
            </Card>

            <Card>
              <CardContent className="p-6 text-center">
                <Shield className="h-12 w-12 text-primary mx-auto mb-4" />
                <h3 className="mb-2">Quality Guaranteed</h3>
                <p className="text-sm text-muted-foreground">
                  Rigorous testing and quality assurance on every project
                </p>
              </CardContent>
            </Card>

            <Card>
              <CardContent className="p-6 text-center">
                <Users className="h-12 w-12 text-primary mx-auto mb-4" />
                <h3 className="mb-2">Ongoing Support</h3>
                <p className="text-sm text-muted-foreground">
                  30 days of post-launch support included with every project
                </p>
              </CardContent>
            </Card>
          </div>
        </section>

        {/* CTA */}
        <section className="mt-20">
          <Card className="bg-gradient-to-r from-primary to-blue-600 text-white border-0">
            <CardContent className="p-12 text-center">
              <h2 className="text-3xl mb-4">Ready to Start Your Project?</h2>
              <p className="text-lg opacity-90 mb-8 max-w-2xl mx-auto">
                Let's discuss your requirements and create something amazing
                together.
              </p>
              <div className="flex flex-col sm:flex-row gap-4 justify-center">
                <Button size="lg" variant="secondary">
                  Schedule a Call
                </Button>
                <Button
                  size="lg"
                  variant="outline"
                  className="bg-transparent border-white text-white hover:bg-white/10"
                  onClick={() => onNavigate('contact')}
                >
                  Contact Us
                </Button>
              </div>
            </CardContent>
          </Card>
        </section>
      </div>
    </div>
  );
}
