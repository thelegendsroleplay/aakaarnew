import { Input } from './ui/input';
import { Button } from './ui/button';
import { Sparkles, Send } from 'lucide-react';

interface FooterProps {
  onNavigate: (page: string) => void;
}

export function Footer({ onNavigate }: FooterProps) {
  return (
    <footer className="relative mt-32 border-t border-gray-200 bg-white">
      <div className="container mx-auto px-4 py-16">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
          {/* Brand */}
          <div className="lg:col-span-1">
            <div className="flex items-center space-x-2 mb-6">
              <div className="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-blue-600 to-blue-500 shadow-lg shadow-blue-500/30">
                <Sparkles className="h-5 w-5 text-white" />
              </div>
              <span className="text-xl font-bold text-gray-900">Aakaari</span>
            </div>
            <p className="text-gray-600 mb-6 leading-relaxed">
              Professional website support by real experts. No bots, no AI—just human expertise you can trust.
            </p>
          </div>

          {/* Services */}
          <div>
            <h4 className="font-semibold mb-6 text-gray-900">Services</h4>
            <ul className="space-y-3">
              {[
                { label: 'Fix-an-Issue', page: 'fix-an-issue' },
                { label: 'Maintenance Plans', page: 'maintenance' },
                { label: 'Build Solutions', page: 'build-solutions' },
              ].map((item) => (
                <li key={item.page}>
                  <button
                    onClick={() => onNavigate(item.page)}
                    className="text-gray-600 hover:text-blue-600 transition-colors"
                  >
                    {item.label}
                  </button>
                </li>
              ))}
            </ul>
          </div>

          {/* Company */}
          <div>
            <h4 className="font-semibold mb-6 text-gray-900">Company</h4>
            <ul className="space-y-3">
              {[
                { label: 'About Us', page: 'home' },
                { label: 'Blog', page: 'blog' },
                { label: 'Contact', page: 'contact' },
                { label: 'Dashboard', page: 'dashboard' },
              ].map((item) => (
                <li key={item.page}>
                  <button
                    onClick={() => onNavigate(item.page)}
                    className="text-gray-600 hover:text-blue-600 transition-colors"
                  >
                    {item.label}
                  </button>
                </li>
              ))}
            </ul>
          </div>

          {/* Newsletter */}
          <div>
            <h4 className="font-semibold mb-6 text-gray-900">Stay Updated</h4>
            <p className="text-gray-600 mb-4 text-sm">
              Get WordPress tips and exclusive offers
            </p>
            <div className="flex gap-2">
              <Input
                type="email"
                placeholder="Enter your email"
                className="rounded-full border-gray-300"
              />
              <Button
                size="icon"
                className="rounded-full bg-gradient-to-r from-blue-600 to-blue-500 shadow-lg shadow-blue-500/30 flex-shrink-0"
              >
                <Send className="h-4 w-4" />
              </Button>
            </div>
          </div>
        </div>

        {/* Bottom Bar */}
        <div className="pt-8 border-t border-gray-200 flex flex-col md:flex-row justify-between items-center gap-4">
          <p className="text-gray-500 text-sm">
            © {new Date().getFullYear()} Aakaari. All rights reserved.
          </p>
          <div className="flex gap-6 text-sm">
            <button className="text-gray-500 hover:text-blue-600 transition-colors">
              Privacy Policy
            </button>
            <button className="text-gray-500 hover:text-blue-600 transition-colors">
              Terms of Service
            </button>
            <button className="text-gray-500 hover:text-blue-600 transition-colors">
              Refund Policy
            </button>
          </div>
        </div>
      </div>
    </footer>
  );
}
