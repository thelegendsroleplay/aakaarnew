import { useState } from 'react';
import { Button } from './ui/button';
import { Avatar, AvatarFallback } from './ui/avatar';
import { Badge } from './ui/badge';
import {
  LayoutDashboard,
  Ticket,
  FileText,
  CreditCard,
  MessageSquare,
  Settings,
  Shield,
  User,
  LogOut,
  Menu,
  X,
} from 'lucide-react';
import { DashboardOverview } from './DashboardOverview';
import { TicketsPage } from './TicketsPage';
import { LiveChat } from './LiveChat';
import { AccessManagement } from './AccessManagement';

interface DashboardPageProps {
  onNavigate: (page: string) => void;
}

export function DashboardPage({ onNavigate }: DashboardPageProps) {
  const [activeTab, setActiveTab] = useState('overview');
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

  const menuItems = [
    { id: 'overview', label: 'Overview', icon: LayoutDashboard },
    { id: 'tickets', label: 'My Tickets', icon: Ticket },
    { id: 'orders', label: 'Orders', icon: FileText },
    { id: 'payments', label: 'Payments', icon: CreditCard },
    { id: 'chat', label: 'Live Chat', icon: MessageSquare },
    { id: 'access', label: 'Access Management', icon: Shield },
    { id: 'settings', label: 'Settings', icon: Settings },
  ];

  const renderContent = () => {
    switch (activeTab) {
      case 'overview':
        return <DashboardOverview onNavigate={onNavigate} />;
      case 'tickets':
        return <TicketsPage onNavigate={onNavigate} />;
      case 'chat':
        return <LiveChat />;
      case 'access':
        return <AccessManagement />;
      case 'orders':
        return (
          <div className="flex items-center justify-center h-64">
            <p className="text-muted-foreground">Orders page coming soon...</p>
          </div>
        );
      case 'payments':
        return (
          <div className="flex items-center justify-center h-64">
            <p className="text-muted-foreground">Payments page coming soon...</p>
          </div>
        );
      case 'settings':
        return (
          <div className="flex items-center justify-center h-64">
            <p className="text-muted-foreground">Settings page coming soon...</p>
          </div>
        );
      default:
        return <DashboardOverview onNavigate={onNavigate} />;
    }
  };

  return (
    <div className="min-h-screen bg-muted/30">
      <div className="flex">
        {/* Sidebar - Desktop */}
        <aside className="hidden lg:flex w-64 flex-col fixed left-0 top-16 h-[calc(100vh-4rem)] bg-white border-r">
          {/* User Profile */}
          <div className="p-6 border-b">
            <div className="flex items-center">
              <Avatar className="h-12 w-12 mr-3">
                <AvatarFallback className="bg-primary text-white">JD</AvatarFallback>
              </Avatar>
              <div className="flex-1">
                <p className="font-medium">John Doe</p>
                <p className="text-sm text-muted-foreground">john@example.com</p>
              </div>
            </div>
          </div>

          {/* Navigation */}
          <nav className="flex-1 p-4 overflow-y-auto">
            <div className="space-y-1">
              {menuItems.map((item) => (
                <button
                  key={item.id}
                  onClick={() => setActiveTab(item.id)}
                  className={`w-full flex items-center px-4 py-3 rounded-lg text-sm transition-colors ${
                    activeTab === item.id
                      ? 'bg-primary text-white'
                      : 'text-foreground hover:bg-accent'
                  }`}
                >
                  <item.icon className="h-5 w-5 mr-3" />
                  {item.label}
                  {item.id === 'tickets' && (
                    <Badge variant="secondary" className="ml-auto">
                      3
                    </Badge>
                  )}
                  {item.id === 'chat' && (
                    <span className="ml-auto h-2 w-2 bg-green-500 rounded-full"></span>
                  )}
                </button>
              ))}
            </div>
          </nav>

          {/* Logout */}
          <div className="p-4 border-t">
            <Button
              variant="ghost"
              className="w-full justify-start text-destructive hover:text-destructive hover:bg-destructive/10"
            >
              <LogOut className="h-5 w-5 mr-3" />
              Logout
            </Button>
          </div>
        </aside>

        {/* Main Content */}
        <main className="flex-1 lg:ml-64 p-6 mt-16">
          {/* Mobile Header */}
          <div className="lg:hidden mb-6 flex items-center justify-between">
            <h1 className="text-2xl font-bold">Dashboard</h1>
            <Button
              variant="ghost"
              size="icon"
              onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
            >
              {mobileMenuOpen ? (
                <X className="h-6 w-6" />
              ) : (
                <Menu className="h-6 w-6" />
              )}
            </Button>
          </div>

          {/* Mobile Menu */}
          {mobileMenuOpen && (
            <div className="lg:hidden mb-6 bg-white border rounded-lg p-4">
              <div className="flex items-center mb-4 pb-4 border-b">
                <Avatar className="h-10 w-10 mr-3">
                  <AvatarFallback className="bg-primary text-white">JD</AvatarFallback>
                </Avatar>
                <div>
                  <p className="font-medium">John Doe</p>
                  <p className="text-sm text-muted-foreground">john@example.com</p>
                </div>
              </div>
              <div className="space-y-1">
                {menuItems.map((item) => (
                  <button
                    key={item.id}
                    onClick={() => {
                      setActiveTab(item.id);
                      setMobileMenuOpen(false);
                    }}
                    className={`w-full flex items-center px-3 py-2 rounded-lg text-sm transition-colors ${
                      activeTab === item.id
                        ? 'bg-primary text-white'
                        : 'text-foreground hover:bg-accent'
                    }`}
                  >
                    <item.icon className="h-5 w-5 mr-3" />
                    {item.label}
                  </button>
                ))}
              </div>
            </div>
          )}

          {/* Content */}
          <div className="max-w-7xl mx-auto">{renderContent()}</div>
        </main>
      </div>
    </div>
  );
}