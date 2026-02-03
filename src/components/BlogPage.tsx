import { Card, CardContent, CardDescription, CardHeader, CardTitle } from './ui/card';
import { Badge } from './ui/badge';
import { Calendar, User, ArrowRight } from 'lucide-react';
import { Button } from './ui/button';

interface BlogPageProps {
  onNavigate: (page: string) => void;
}

export function BlogPage({ onNavigate }: BlogPageProps) {
  const posts = [
    {
      id: 1,
      title: '10 Common WordPress Security Issues and How to Fix Them',
      excerpt:
        'Learn about the most common security vulnerabilities in WordPress websites and how our team can help protect your site.',
      category: 'Security',
      author: 'John Smith',
      date: 'January 28, 2026',
      readTime: '5 min read',
    },
    {
      id: 2,
      title: 'Why Regular Website Maintenance Matters',
      excerpt:
        'Discover the importance of regular website maintenance and how it can save you money in the long run.',
      category: 'Maintenance',
      author: 'Sarah Johnson',
      date: 'January 25, 2026',
      readTime: '4 min read',
    },
    {
      id: 3,
      title: 'How to Choose the Right WordPress Hosting',
      excerpt:
        'A comprehensive guide to selecting the best hosting provider for your WordPress website needs.',
      category: 'Guide',
      author: 'Michael Chen',
      date: 'January 22, 2026',
      readTime: '7 min read',
    },
    {
      id: 4,
      title: 'Speed Optimization: Make Your Site Load in Under 2 Seconds',
      excerpt:
        'Expert tips and techniques for optimizing your website speed and improving user experience.',
      category: 'Performance',
      author: 'Emily Rodriguez',
      date: 'January 20, 2026',
      readTime: '6 min read',
    },
    {
      id: 5,
      title: 'Understanding WordPress Plugin Conflicts',
      excerpt:
        'Learn how to identify and resolve plugin conflicts that might be breaking your website.',
      category: 'Troubleshooting',
      author: 'John Smith',
      date: 'January 18, 2026',
      readTime: '5 min read',
    },
    {
      id: 6,
      title: 'Best Practices for WordPress Backup Strategies',
      excerpt:
        'Essential backup strategies to ensure your website data is always safe and recoverable.',
      category: 'Security',
      author: 'Sarah Johnson',
      date: 'January 15, 2026',
      readTime: '6 min read',
    },
  ];

  const categories = ['All', 'Security', 'Maintenance', 'Guide', 'Performance', 'Troubleshooting'];

  return (
    <div className="w-full py-12">
      <div className="container mx-auto px-4">
        {/* Header */}
        <div className="max-w-3xl mx-auto text-center mb-12">
          <h1 className="text-4xl md:text-5xl mb-4">Blog & Resources</h1>
          <p className="text-lg text-muted-foreground">
            Expert insights, tips, and guides for managing your WordPress website
          </p>
        </div>

        {/* Categories */}
        <div className="flex flex-wrap gap-2 justify-center mb-12">
          {categories.map((category) => (
            <Badge
              key={category}
              variant={category === 'All' ? 'default' : 'outline'}
              className="cursor-pointer"
            >
              {category}
            </Badge>
          ))}
        </div>

        {/* Blog Posts Grid */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
          {posts.map((post) => (
            <Card key={post.id} className="hover:shadow-lg transition-shadow cursor-pointer">
              <CardHeader>
                <div className="flex items-center justify-between mb-2">
                  <Badge variant="secondary">{post.category}</Badge>
                  <span className="text-xs text-muted-foreground">{post.readTime}</span>
                </div>
                <CardTitle className="line-clamp-2">{post.title}</CardTitle>
                <CardDescription className="line-clamp-3">{post.excerpt}</CardDescription>
              </CardHeader>
              <CardContent>
                <div className="flex items-center justify-between text-sm text-muted-foreground mb-4">
                  <div className="flex items-center">
                    <User className="h-4 w-4 mr-1" />
                    {post.author}
                  </div>
                  <div className="flex items-center">
                    <Calendar className="h-4 w-4 mr-1" />
                    {post.date}
                  </div>
                </div>
                <Button variant="ghost" size="sm" className="w-full">
                  Read More <ArrowRight className="ml-2 h-4 w-4" />
                </Button>
              </CardContent>
            </Card>
          ))}
        </div>

        {/* Newsletter CTA */}
        <Card className="mt-16 max-w-3xl mx-auto bg-gradient-to-r from-primary to-blue-600 text-white border-0">
          <CardContent className="p-8 text-center">
            <h3 className="text-2xl mb-2">Get Website Tips in Your Inbox</h3>
            <p className="opacity-90 mb-6">
              Subscribe to receive expert WordPress tips, security updates, and exclusive offers.
            </p>
            <Button variant="secondary" size="lg" onClick={() => onNavigate('home')}>
              Subscribe Now
            </Button>
          </CardContent>
        </Card>
      </div>
    </div>
  );
}
