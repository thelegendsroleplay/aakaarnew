import { useState, useEffect } from 'react';
import { Button } from './ui/button';
import { Sheet, SheetContent, SheetTrigger } from './ui/sheet';
import { Menu, Sparkles, LogIn } from 'lucide-react';

interface HeaderProps {
  currentPage: string;
  onNavigate: (page: string) => void;
}

export function Header({ currentPage, onNavigate }: HeaderProps) {
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
  const [scrolled, setScrolled] = useState(false);

  useEffect(() => {
    const handleScroll = () => {
      setScrolled(window.scrollY > 20);
    };
    window.addEventListener('scroll', handleScroll);
    return () => window.removeEventListener('scroll', handleScroll);
  }, []);

  const navItems = [
    { id: 'home', label: 'Home' },
    { id: 'fix-an-issue', label: 'Fix Issue' },
    { id: 'maintenance', label: 'Maintenance' },
    { id: 'build-solutions', label: 'Build' },
    { id: 'blog', label: 'Blog' },
  ];

  return (
    <header className="fixed top-0 left-0 right-0 z-50 px-4 py-4">
      <div className="container mx-auto">
        {/* Capsule Container */}
        <div
          className={`relative bg-white/80 backdrop-blur-xl border border-gray-200 rounded-full transition-all duration-300 ${
            scrolled ? 'shadow-xl shadow-blue-500/10' : 'shadow-lg'
          }`}
        >
          <div className="relative flex items-center justify-between px-6 py-3">
            {/* Logo */}
            <button
              onClick={() => onNavigate('home')}
              className="flex items-center space-x-2 group"
            >
              <div className="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 shadow-lg shadow-blue-500/30">
                <Sparkles className="h-5 w-5 text-white" />
              </div>
              <span className="text-xl font-bold text-gray-900">
                Aakaari
              </span>
            </button>

            {/* Desktop Navigation */}
            <nav className="hidden lg:flex items-center space-x-1">
              {navItems.map((item) => (
                <button
                  key={item.id}
                  onClick={() => onNavigate(item.id)}
                  className={`px-5 py-2.5 rounded-full text-sm font-medium transition-all duration-200 ${
                    currentPage === item.id
                      ? 'bg-blue-50 text-blue-600'
                      : 'text-gray-600 hover:text-blue-600 hover:bg-gray-50'
                  }`}
                >
                  {item.label}
                </button>
              ))}
            </nav>

            {/* Right Section */}
            <div className="hidden lg:flex items-center space-x-3">
              <Button
                variant="ghost"
                onClick={() => onNavigate('dashboard')}
                className="rounded-full text-gray-600 hover:text-blue-600"
              >
                Dashboard
              </Button>
              <Button
                onClick={() => onNavigate('fix-an-issue')}
                className="rounded-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white shadow-lg shadow-blue-500/30"
              >
                Get Started
              </Button>
            </div>

            {/* Mobile Menu Button */}
            <Sheet open={mobileMenuOpen} onOpenChange={setMobileMenuOpen}>
              <SheetTrigger asChild className="lg:hidden">
                <Button
                  variant="ghost"
                  size="icon"
                  className="rounded-full text-gray-600"
                >
                  <Menu className="h-5 w-5" />
                </Button>
              </SheetTrigger>
              <SheetContent
                side="right"
                className="w-[300px] bg-white"
              >
                <nav className="flex flex-col space-y-2 mt-8">
                  {navItems.map((item) => (
                    <button
                      key={item.id}
                      onClick={() => {
                        onNavigate(item.id);
                        setMobileMenuOpen(false);
                      }}
                      className={`text-left px-4 py-3 rounded-xl text-sm font-medium transition-all ${
                        currentPage === item.id
                          ? 'bg-blue-50 text-blue-600'
                          : 'text-gray-600 hover:text-blue-600 hover:bg-gray-50'
                      }`}
                    >
                      {item.label}
                    </button>
                  ))}
                  <div className="pt-4 space-y-2">
                    <Button
                      variant="outline"
                      onClick={() => {
                        onNavigate('dashboard');
                        setMobileMenuOpen(false);
                      }}
                      className="w-full rounded-xl"
                    >
                      Dashboard
                    </Button>
                    <Button
                      onClick={() => {
                        onNavigate('fix-an-issue');
                        setMobileMenuOpen(false);
                      }}
                      className="w-full rounded-xl bg-gradient-to-r from-blue-500 to-blue-600"
                    >
                      Get Started
                    </Button>
                  </div>
                </nav>
              </SheetContent>
            </Sheet>
          </div>
        </div>
      </div>
    </header>
  );
}