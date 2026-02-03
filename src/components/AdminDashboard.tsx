import { useState } from 'react';
import { Button } from './ui/button';
import { Avatar, AvatarFallback } from './ui/avatar';
import { Badge } from './ui/badge';
import { Card } from './ui/card';
import { Input } from './ui/input';
import { Label } from './ui/label';
import { Textarea } from './ui/textarea';
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from './ui/select';
import {
  LayoutDashboard,
  Ticket,
  Users,
  DollarSign,
  Settings,
  LogOut,
  Menu,
  X,
  TrendingUp,
  Clock,
  CheckCircle,
  AlertCircle,
  Search,
  Filter,
  Download,
  Upload,
  Plus,
  Edit,
  Trash2,
  Eye,
  UserPlus,
  Bell,
  BarChart3,
  Calendar,
  FileText,
  MessageSquare,
  Activity,
  Zap,
  Shield,
  Globe,
  Mail,
  Phone,
  MapPin,
  ExternalLink,
} from 'lucide-react';
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from './ui/dialog';
import { Tabs, TabsContent, TabsList, TabsTrigger } from './ui/tabs';

interface AdminDashboardProps {
  onNavigate: (page: string) => void;
  onLogout: () => void;
}

export function AdminDashboard({ onNavigate, onLogout }: AdminDashboardProps) {
  const [activeTab, setActiveTab] = useState('overview');
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
  const [ticketFilter, setTicketFilter] = useState('all');
  const [selectedTicket, setSelectedTicket] = useState<any>(null);

  const menuItems = [
    { id: 'overview', label: 'Overview', icon: LayoutDashboard },
    { id: 'tickets', label: 'All Tickets', icon: Ticket, badge: '24' },
    { id: 'clients', label: 'Clients', icon: Users },
    { id: 'team', label: 'Team', icon: UserPlus },
    { id: 'revenue', label: 'Revenue', icon: DollarSign },
    { id: 'analytics', label: 'Analytics', icon: BarChart3 },
    { id: 'notifications', label: 'Notifications', icon: Bell, badge: '5' },
    { id: 'settings', label: 'Settings', icon: Settings },
  ];

  const stats = [
    {
      label: 'Active Tickets',
      value: '24',
      change: '+12%',
      trend: 'up',
      icon: Ticket,
      color: 'blue',
      subtext: '8 Critical',
    },
    {
      label: 'Total Clients',
      value: '487',
      change: '+8%',
      trend: 'up',
      icon: Users,
      color: 'green',
      subtext: '23 New this week',
    },
    {
      label: 'Revenue (MTD)',
      value: '$12,450',
      change: '+23%',
      trend: 'up',
      icon: DollarSign,
      color: 'purple',
      subtext: '$45k target',
    },
    {
      label: 'Avg Response',
      value: '1.2hrs',
      change: '-15%',
      trend: 'down',
      icon: Clock,
      color: 'yellow',
      subtext: 'Target: <2hrs',
    },
  ];

  const allTickets = [
    {
      id: 'TKT-1234',
      client: 'Sarah Chen',
      clientEmail: 'sarah@ecommerce.com',
      website: 'ecommerce-store.com',
      issue: 'White Screen of Death',
      category: 'WordPress Core',
      priority: 'critical',
      status: 'in-progress',
      tier: 'Advanced',
      price: '$79',
      assignedTo: 'Mike R.',
      assignedAvatar: 'MR',
      created: '2 hours ago',
      updated: '15 mins ago',
      deadline: '45 mins',
      description: 'Site showing white screen after plugin update. Need urgent help.',
    },
    {
      id: 'TKT-1233',
      client: 'Marcus Rodriguez',
      clientEmail: 'marcus@agency.com',
      website: 'digital-agency.com',
      issue: 'Plugin Conflict',
      category: 'WordPress Core',
      priority: 'high',
      status: 'pending',
      tier: 'Standard',
      price: '$45',
      assignedTo: 'Unassigned',
      assignedAvatar: 'UN',
      created: '3 hours ago',
      updated: '1 hour ago',
      deadline: '5 hours',
      description: 'Contact form stopped working after recent updates.',
    },
    {
      id: 'TKT-1232',
      client: 'Lisa Thompson',
      clientEmail: 'lisa@blog.com',
      website: 'lifestyle-blog.com',
      issue: 'Slow Loading Speed',
      category: 'Performance',
      priority: 'medium',
      status: 'completed',
      tier: 'Basic',
      price: '$29',
      assignedTo: 'Anna K.',
      assignedAvatar: 'AK',
      created: '5 hours ago',
      updated: '2 hours ago',
      deadline: 'Completed',
      description: 'Website loading very slow, especially on mobile.',
    },
    {
      id: 'TKT-1231',
      client: 'David Kim',
      clientEmail: 'david@startup.io',
      website: 'tech-startup.io',
      issue: 'Email Not Sending',
      category: 'Infrastructure',
      priority: 'high',
      status: 'in-progress',
      tier: 'Standard',
      price: '$29',
      assignedTo: 'John D.',
      assignedAvatar: 'JD',
      created: '6 hours ago',
      updated: '3 hours ago',
      deadline: '2 hours',
      description: 'Contact form emails not being delivered to inbox.',
    },
    {
      id: 'TKT-1230',
      client: 'Emma Wilson',
      clientEmail: 'emma@shop.com',
      website: 'fashion-shop.com',
      issue: 'Payment Gateway Issue',
      category: 'WooCommerce',
      priority: 'critical',
      status: 'pending',
      tier: 'Advanced',
      price: '$149',
      assignedTo: 'Unassigned',
      assignedAvatar: 'UN',
      created: '7 hours ago',
      updated: '4 hours ago',
      deadline: '1 hour',
      description: 'PayPal checkout not working, customers cannot complete orders.',
    },
  ];

  const clients = [
    {
      id: 'CL-001',
      name: 'Sarah Chen',
      email: 'sarah@ecommerce.com',
      phone: '+1 (555) 123-4567',
      website: 'ecommerce-store.com',
      plan: 'Premium',
      joinedDate: 'Jan 15, 2024',
      totalSpent: '$1,245',
      activeTickets: 2,
      resolvedTickets: 12,
      status: 'active',
    },
    {
      id: 'CL-002',
      name: 'Marcus Rodriguez',
      email: 'marcus@agency.com',
      phone: '+1 (555) 234-5678',
      website: 'digital-agency.com',
      plan: 'Business',
      joinedDate: 'Dec 3, 2023',
      totalSpent: '$2,890',
      activeTickets: 1,
      resolvedTickets: 28,
      status: 'active',
    },
    {
      id: 'CL-003',
      name: 'Lisa Thompson',
      email: 'lisa@blog.com',
      phone: '+1 (555) 345-6789',
      website: 'lifestyle-blog.com',
      plan: 'Standard',
      joinedDate: 'Feb 20, 2024',
      totalSpent: '$450',
      activeTickets: 0,
      resolvedTickets: 5,
      status: 'active',
    },
    {
      id: 'CL-004',
      name: 'David Kim',
      email: 'david@startup.io',
      phone: '+1 (555) 456-7890',
      website: 'tech-startup.io',
      plan: 'Premium',
      joinedDate: 'Nov 8, 2023',
      totalSpent: '$3,200',
      activeTickets: 1,
      resolvedTickets: 34,
      status: 'active',
    },
  ];

  const teamMembers = [
    {
      id: 'TM-001',
      name: 'Mike Roberts',
      email: 'mike@aakaari.com',
      role: 'Senior Engineer',
      avatar: 'MR',
      activeTickets: 5,
      completedToday: 3,
      avgResponseTime: '45 mins',
      rating: 4.9,
      status: 'online',
    },
    {
      id: 'TM-002',
      name: 'Anna Kumar',
      email: 'anna@aakaari.com',
      role: 'WordPress Specialist',
      avatar: 'AK',
      activeTickets: 4,
      completedToday: 2,
      avgResponseTime: '1.2 hrs',
      rating: 4.8,
      status: 'online',
    },
    {
      id: 'TM-003',
      name: 'John Davis',
      email: 'john@aakaari.com',
      role: 'Full Stack Developer',
      avatar: 'JD',
      activeTickets: 6,
      completedToday: 1,
      avgResponseTime: '50 mins',
      rating: 4.7,
      status: 'busy',
    },
    {
      id: 'TM-004',
      name: 'Sarah Mitchell',
      email: 'sarah.m@aakaari.com',
      role: 'Security Expert',
      avatar: 'SM',
      activeTickets: 3,
      completedToday: 4,
      avgResponseTime: '35 mins',
      rating: 5.0,
      status: 'online',
    },
  ];

  const revenueData = [
    { month: 'Jan', revenue: 8500, tickets: 45, avgTicket: 189 },
    { month: 'Feb', revenue: 12450, tickets: 62, avgTicket: 201 },
    { month: 'Mar (MTD)', revenue: 12450, tickets: 58, avgTicket: 215 },
  ];

  const getPriorityColor = (priority: string) => {
    switch (priority) {
      case 'critical':
        return 'bg-red-50 text-red-600 border-red-200';
      case 'high':
        return 'bg-amber-50 text-amber-600 border-amber-200';
      case 'medium':
        return 'bg-blue-50 text-blue-600 border-blue-200';
      default:
        return 'bg-gray-50 text-gray-600 border-gray-200';
    }
  };

  const getStatusColor = (status: string) => {
    switch (status) {
      case 'completed':
        return 'bg-green-50 text-green-600 border-green-200';
      case 'in-progress':
        return 'bg-blue-50 text-blue-600 border-blue-200';
      case 'pending':
        return 'bg-yellow-50 text-yellow-600 border-yellow-200';
      default:
        return 'bg-gray-50 text-gray-600 border-gray-200';
    }
  };

  const getOnlineStatusColor = (status: string) => {
    switch (status) {
      case 'online':
        return 'bg-green-500';
      case 'busy':
        return 'bg-yellow-500';
      case 'offline':
        return 'bg-gray-400';
      default:
        return 'bg-gray-400';
    }
  };

  const filteredTickets =
    ticketFilter === 'all'
      ? allTickets
      : allTickets.filter((t) => t.status === ticketFilter);

  const renderContent = () => {
    switch (activeTab) {
      case 'overview':
        return (
          <div className="space-y-6">
            {/* Stats Grid */}
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
              {stats.map((stat, index) => (
                <Card key={index} className="p-6 border-2 border-gray-200 hover:shadow-xl transition-all">
                  <div className="flex items-center justify-between mb-4">
                    <div
                      className={`flex h-12 w-12 items-center justify-center rounded-xl bg-${stat.color}-50`}
                    >
                      <stat.icon className={`h-6 w-6 text-${stat.color}-600`} />
                    </div>
                    <Badge
                      className={`${
                        stat.trend === 'up'
                          ? 'bg-green-50 text-green-600'
                          : 'bg-red-50 text-red-600'
                      } border-0`}
                    >
                      {stat.change}
                    </Badge>
                  </div>
                  <p className="text-sm text-gray-600 mb-1">{stat.label}</p>
                  <p className="text-3xl font-bold text-gray-900 mb-1">{stat.value}</p>
                  <p className="text-xs text-gray-500">{stat.subtext}</p>
                </Card>
              ))}
            </div>

            {/* Quick Actions */}
            <Card className="p-6 border-2 border-gray-200">
              <h3 className="text-lg font-bold text-gray-900 mb-4">Quick Actions</h3>
              <div className="grid grid-cols-2 md:grid-cols-4 gap-3">
                <Button variant="outline" className="flex-col h-auto py-4 border-2">
                  <Plus className="h-5 w-5 mb-2" />
                  <span className="text-sm">New Ticket</span>
                </Button>
                <Button variant="outline" className="flex-col h-auto py-4 border-2">
                  <UserPlus className="h-5 w-5 mb-2" />
                  <span className="text-sm">Add Client</span>
                </Button>
                <Button variant="outline" className="flex-col h-auto py-4 border-2">
                  <Download className="h-5 w-5 mb-2" />
                  <span className="text-sm">Export Data</span>
                </Button>
                <Button variant="outline" className="flex-col h-auto py-4 border-2">
                  <BarChart3 className="h-5 w-5 mb-2" />
                  <span className="text-sm">Reports</span>
                </Button>
              </div>
            </Card>

            {/* Recent Activity */}
            <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
              <Card className="p-6 border-2 border-gray-200">
                <h3 className="text-lg font-bold text-gray-900 mb-4 flex items-center">
                  <Activity className="h-5 w-5 mr-2 text-purple-600" />
                  Recent Activity
                </h3>
                <div className="space-y-4">
                  {[
                    {
                      action: 'Ticket TKT-1234 assigned to Mike R.',
                      time: '5 mins ago',
                      type: 'assignment',
                    },
                    {
                      action: 'Payment received from Sarah Chen ($79)',
                      time: '12 mins ago',
                      type: 'payment',
                    },
                    {
                      action: 'New client registered: Emma Wilson',
                      time: '25 mins ago',
                      type: 'client',
                    },
                    {
                      action: 'Ticket TKT-1232 marked as completed',
                      time: '1 hour ago',
                      type: 'completion',
                    },
                    {
                      action: 'Anna K. updated ticket TKT-1230',
                      time: '2 hours ago',
                      type: 'update',
                    },
                  ].map((activity, idx) => (
                    <div key={idx} className="flex items-start pb-3 border-b border-gray-100 last:border-0">
                      <div className="flex h-8 w-8 items-center justify-center rounded-lg bg-purple-50 mr-3 flex-shrink-0">
                        <Activity className="h-4 w-4 text-purple-600" />
                      </div>
                      <div className="flex-1">
                        <p className="text-sm text-gray-900">{activity.action}</p>
                        <p className="text-xs text-gray-500">{activity.time}</p>
                      </div>
                    </div>
                  ))}
                </div>
              </Card>

              <Card className="p-6 border-2 border-gray-200">
                <h3 className="text-lg font-bold text-gray-900 mb-4 flex items-center">
                  <Zap className="h-5 w-5 mr-2 text-yellow-600" />
                  Team Performance
                </h3>
                <div className="space-y-4">
                  {teamMembers.slice(0, 4).map((member) => (
                    <div key={member.id} className="flex items-center justify-between">
                      <div className="flex items-center">
                        <Avatar className="h-10 w-10 mr-3">
                          <AvatarFallback className="bg-gradient-to-br from-purple-600 to-purple-500 text-white text-sm">
                            {member.avatar}
                          </AvatarFallback>
                        </Avatar>
                        <div>
                          <p className="text-sm font-medium text-gray-900">{member.name}</p>
                          <p className="text-xs text-gray-500">{member.role}</p>
                        </div>
                      </div>
                      <div className="text-right">
                        <p className="text-sm font-semibold text-gray-900">
                          {member.activeTickets} active
                        </p>
                        <p className="text-xs text-green-600">+{member.completedToday} today</p>
                      </div>
                    </div>
                  ))}
                </div>
              </Card>
            </div>
          </div>
        );

      case 'tickets':
        return (
          <div className="space-y-6">
            <Card className="p-6 border-2 border-gray-200">
              <div className="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
                <div>
                  <h3 className="text-2xl font-bold text-gray-900">All Tickets</h3>
                  <p className="text-sm text-gray-600">
                    Manage and track all support tickets
                  </p>
                </div>
                <div className="flex gap-2">
                  <div className="relative">
                    <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" />
                    <Input
                      placeholder="Search tickets..."
                      className="pl-9 w-64 border-gray-300"
                    />
                  </div>
                  <Select value={ticketFilter} onValueChange={setTicketFilter}>
                    <SelectTrigger className="w-40 border-gray-300">
                      <SelectValue />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectItem value="all">All Status</SelectItem>
                      <SelectItem value="pending">Pending</SelectItem>
                      <SelectItem value="in-progress">In Progress</SelectItem>
                      <SelectItem value="completed">Completed</SelectItem>
                    </SelectContent>
                  </Select>
                  <Button className="bg-gradient-to-r from-purple-600 to-purple-500">
                    <Plus className="h-4 w-4 mr-2" />
                    New Ticket
                  </Button>
                </div>
              </div>

              <div className="overflow-x-auto">
                <table className="w-full">
                  <thead>
                    <tr className="border-b-2 border-gray-200">
                      <th className="text-left py-4 px-4 text-sm font-semibold text-gray-700">
                        Ticket
                      </th>
                      <th className="text-left py-4 px-4 text-sm font-semibold text-gray-700">
                        Client
                      </th>
                      <th className="text-left py-4 px-4 text-sm font-semibold text-gray-700">
                        Issue
                      </th>
                      <th className="text-left py-4 px-4 text-sm font-semibold text-gray-700">
                        Priority
                      </th>
                      <th className="text-left py-4 px-4 text-sm font-semibold text-gray-700">
                        Status
                      </th>
                      <th className="text-left py-4 px-4 text-sm font-semibold text-gray-700">
                        Assigned
                      </th>
                      <th className="text-left py-4 px-4 text-sm font-semibold text-gray-700">
                        Deadline
                      </th>
                      <th className="text-left py-4 px-4 text-sm font-semibold text-gray-700">
                        Actions
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    {filteredTickets.map((ticket) => (
                      <tr
                        key={ticket.id}
                        className="border-b border-gray-100 hover:bg-gray-50"
                      >
                        <td className="py-4 px-4">
                          <div>
                            <span className="font-mono text-sm font-medium text-blue-600">
                              {ticket.id}
                            </span>
                            <p className="text-xs text-gray-500">{ticket.tier} • {ticket.price}</p>
                          </div>
                        </td>
                        <td className="py-4 px-4">
                          <div className="flex items-center">
                            <Avatar className="h-8 w-8 mr-2">
                              <AvatarFallback className="bg-gradient-to-br from-blue-600 to-blue-500 text-white text-xs">
                                {ticket.client
                                  .split(' ')
                                  .map((n) => n[0])
                                  .join('')}
                              </AvatarFallback>
                            </Avatar>
                            <div>
                              <p className="text-sm font-medium text-gray-900">{ticket.client}</p>
                              <p className="text-xs text-gray-500">{ticket.website}</p>
                            </div>
                          </div>
                        </td>
                        <td className="py-4 px-4">
                          <p className="text-sm text-gray-900">{ticket.issue}</p>
                          <p className="text-xs text-gray-500">{ticket.category}</p>
                        </td>
                        <td className="py-4 px-4">
                          <Badge
                            className={`${getPriorityColor(ticket.priority)} text-xs capitalize`}
                          >
                            {ticket.priority}
                          </Badge>
                        </td>
                        <td className="py-4 px-4">
                          <Badge
                            className={`${getStatusColor(ticket.status)} text-xs capitalize`}
                          >
                            {ticket.status.replace('-', ' ')}
                          </Badge>
                        </td>
                        <td className="py-4 px-4">
                          <div className="flex items-center">
                            <Avatar className="h-6 w-6 mr-1">
                              <AvatarFallback className="bg-purple-100 text-purple-600 text-xs">
                                {ticket.assignedAvatar}
                              </AvatarFallback>
                            </Avatar>
                            <span className="text-sm text-gray-700">{ticket.assignedTo}</span>
                          </div>
                        </td>
                        <td className="py-4 px-4">
                          <span
                            className={`text-sm ${
                              ticket.deadline.includes('Completed')
                                ? 'text-green-600'
                                : ticket.deadline.includes('min')
                                ? 'text-red-600 font-semibold'
                                : 'text-gray-700'
                            }`}
                          >
                            {ticket.deadline}
                          </span>
                        </td>
                        <td className="py-4 px-4">
                          <div className="flex gap-2">
                            <Dialog>
                              <DialogTrigger asChild>
                                <Button
                                  variant="ghost"
                                  size="icon"
                                  className="h-8 w-8"
                                  onClick={() => setSelectedTicket(ticket)}
                                >
                                  <Eye className="h-4 w-4" />
                                </Button>
                              </DialogTrigger>
                              <DialogContent className="max-w-2xl">
                                <DialogHeader>
                                  <DialogTitle className="flex items-center justify-between">
                                    <span>Ticket Details: {ticket.id}</span>
                                    <Badge className={getPriorityColor(ticket.priority)}>
                                      {ticket.priority}
                                    </Badge>
                                  </DialogTitle>
                                  <DialogDescription>
                                    View and manage ticket details, assign team members, and update status
                                  </DialogDescription>
                                </DialogHeader>
                                <div className="space-y-4">
                                  <div className="grid grid-cols-2 gap-4">
                                    <div>
                                      <Label className="text-xs text-gray-500">Client</Label>
                                      <p className="font-medium">{ticket.client}</p>
                                    </div>
                                    <div>
                                      <Label className="text-xs text-gray-500">Website</Label>
                                      <p className="font-medium">{ticket.website}</p>
                                    </div>
                                    <div>
                                      <Label className="text-xs text-gray-500">Issue</Label>
                                      <p className="font-medium">{ticket.issue}</p>
                                    </div>
                                    <div>
                                      <Label className="text-xs text-gray-500">Category</Label>
                                      <p className="font-medium">{ticket.category}</p>
                                    </div>
                                    <div>
                                      <Label className="text-xs text-gray-500">Service Tier</Label>
                                      <p className="font-medium">{ticket.tier} - {ticket.price}</p>
                                    </div>
                                    <div>
                                      <Label className="text-xs text-gray-500">Status</Label>
                                      <Badge className={getStatusColor(ticket.status)}>
                                        {ticket.status}
                                      </Badge>
                                    </div>
                                  </div>
                                  <div>
                                    <Label className="text-xs text-gray-500">Description</Label>
                                    <p className="text-sm mt-1">{ticket.description}</p>
                                  </div>
                                  <div>
                                    <Label className="text-xs text-gray-500">Assigned To</Label>
                                    <Select defaultValue={ticket.assignedTo}>
                                      <SelectTrigger className="mt-1">
                                        <SelectValue />
                                      </SelectTrigger>
                                      <SelectContent>
                                        <SelectItem value="Unassigned">Unassigned</SelectItem>
                                        {teamMembers.map((member) => (
                                          <SelectItem key={member.id} value={member.name}>
                                            {member.name} ({member.activeTickets} active)
                                          </SelectItem>
                                        ))}
                                      </SelectContent>
                                    </Select>
                                  </div>
                                  <div>
                                    <Label className="text-xs text-gray-500">Add Note</Label>
                                    <Textarea
                                      placeholder="Add internal note..."
                                      className="mt-1"
                                      rows={3}
                                    />
                                  </div>
                                  <div className="flex gap-2">
                                    <Button className="flex-1 bg-gradient-to-r from-purple-600 to-purple-500">
                                      Update Ticket
                                    </Button>
                                    <Button variant="outline">Send Message</Button>
                                  </div>
                                </div>
                              </DialogContent>
                            </Dialog>
                            <Button variant="ghost" size="icon" className="h-8 w-8">
                              <Edit className="h-4 w-4" />
                            </Button>
                          </div>
                        </td>
                      </tr>
                    ))}
                  </tbody>
                </table>
              </div>
            </Card>
          </div>
        );

      case 'clients':
        return (
          <div className="space-y-6">
            <Card className="p-6 border-2 border-gray-200">
              <div className="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
                <div>
                  <h3 className="text-2xl font-bold text-gray-900">Clients</h3>
                  <p className="text-sm text-gray-600">
                    Manage customer accounts and relationships
                  </p>
                </div>
                <div className="flex gap-2">
                  <div className="relative">
                    <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" />
                    <Input
                      placeholder="Search clients..."
                      className="pl-9 w-64 border-gray-300"
                    />
                  </div>
                  <Button className="bg-gradient-to-r from-purple-600 to-purple-500">
                    <UserPlus className="h-4 w-4 mr-2" />
                    Add Client
                  </Button>
                </div>
              </div>

              <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                {clients.map((client) => (
                  <Card key={client.id} className="p-6 border-2 border-gray-200 hover:shadow-lg transition-all">
                    <div className="flex items-start justify-between mb-4">
                      <div className="flex items-center">
                        <Avatar className="h-12 w-12 mr-3">
                          <AvatarFallback className="bg-gradient-to-br from-blue-600 to-blue-500 text-white">
                            {client.name
                              .split(' ')
                              .map((n) => n[0])
                              .join('')}
                          </AvatarFallback>
                        </Avatar>
                        <div>
                          <h4 className="font-bold text-gray-900">{client.name}</h4>
                          <p className="text-sm text-gray-500">{client.id}</p>
                        </div>
                      </div>
                      <Badge className="bg-green-50 text-green-600 border-green-200">
                        {client.plan}
                      </Badge>
                    </div>

                    <div className="space-y-2 mb-4">
                      <div className="flex items-center text-sm text-gray-600">
                        <Mail className="h-4 w-4 mr-2 text-gray-400" />
                        {client.email}
                      </div>
                      <div className="flex items-center text-sm text-gray-600">
                        <Phone className="h-4 w-4 mr-2 text-gray-400" />
                        {client.phone}
                      </div>
                      <div className="flex items-center text-sm text-gray-600">
                        <Globe className="h-4 w-4 mr-2 text-gray-400" />
                        {client.website}
                      </div>
                    </div>

                    <div className="grid grid-cols-3 gap-4 py-4 border-t border-gray-200">
                      <div>
                        <p className="text-xs text-gray-500">Total Spent</p>
                        <p className="text-lg font-bold text-gray-900">{client.totalSpent}</p>
                      </div>
                      <div>
                        <p className="text-xs text-gray-500">Active</p>
                        <p className="text-lg font-bold text-blue-600">{client.activeTickets}</p>
                      </div>
                      <div>
                        <p className="text-xs text-gray-500">Resolved</p>
                        <p className="text-lg font-bold text-green-600">{client.resolvedTickets}</p>
                      </div>
                    </div>

                    <div className="flex gap-2 pt-4 border-t border-gray-200">
                      <Button variant="outline" size="sm" className="flex-1">
                        <Eye className="h-4 w-4 mr-2" />
                        View Details
                      </Button>
                      <Button variant="outline" size="sm" className="flex-1">
                        <MessageSquare className="h-4 w-4 mr-2" />
                        Message
                      </Button>
                    </div>
                  </Card>
                ))}
              </div>
            </Card>
          </div>
        );

      case 'team':
        return (
          <div className="space-y-6">
            <Card className="p-6 border-2 border-gray-200">
              <div className="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
                <div>
                  <h3 className="text-2xl font-bold text-gray-900">Team Members</h3>
                  <p className="text-sm text-gray-600">
                    Manage team performance and assignments
                  </p>
                </div>
                <Button className="bg-gradient-to-r from-purple-600 to-purple-500">
                  <UserPlus className="h-4 w-4 mr-2" />
                  Add Team Member
                </Button>
              </div>

              <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                {teamMembers.map((member) => (
                  <Card key={member.id} className="p-6 border-2 border-gray-200 hover:shadow-lg transition-all">
                    <div className="flex items-start justify-between mb-4">
                      <div className="flex items-center">
                        <div className="relative">
                          <Avatar className="h-14 w-14 mr-3">
                            <AvatarFallback className="bg-gradient-to-br from-purple-600 to-purple-500 text-white text-lg">
                              {member.avatar}
                            </AvatarFallback>
                          </Avatar>
                          <span
                            className={`absolute bottom-0 right-2 h-4 w-4 rounded-full border-2 border-white ${getOnlineStatusColor(
                              member.status
                            )}`}
                          ></span>
                        </div>
                        <div>
                          <h4 className="font-bold text-gray-900">{member.name}</h4>
                          <p className="text-sm text-gray-500">{member.role}</p>
                          <p className="text-xs text-gray-400">{member.email}</p>
                        </div>
                      </div>
                      <Badge className="capitalize bg-green-50 text-green-600 border-green-200">
                        {member.status}
                      </Badge>
                    </div>

                    <div className="grid grid-cols-2 gap-4 mb-4">
                      <div className="bg-blue-50 p-3 rounded-lg">
                        <p className="text-xs text-gray-600">Active Tickets</p>
                        <p className="text-2xl font-bold text-blue-600">{member.activeTickets}</p>
                      </div>
                      <div className="bg-green-50 p-3 rounded-lg">
                        <p className="text-xs text-gray-600">Completed Today</p>
                        <p className="text-2xl font-bold text-green-600">
                          {member.completedToday}
                        </p>
                      </div>
                    </div>

                    <div className="space-y-2 pt-4 border-t border-gray-200">
                      <div className="flex justify-between text-sm">
                        <span className="text-gray-600">Avg Response Time:</span>
                        <span className="font-semibold text-gray-900">{member.avgResponseTime}</span>
                      </div>
                      <div className="flex justify-between text-sm">
                        <span className="text-gray-600">Rating:</span>
                        <span className="font-semibold text-yellow-600">
                          ⭐ {member.rating}/5.0
                        </span>
                      </div>
                    </div>

                    <div className="flex gap-2 pt-4 border-t border-gray-200 mt-4">
                      <Button variant="outline" size="sm" className="flex-1">
                        <Eye className="h-4 w-4 mr-2" />
                        View Profile
                      </Button>
                      <Button variant="outline" size="sm" className="flex-1">
                        <MessageSquare className="h-4 w-4 mr-2" />
                        Message
                      </Button>
                    </div>
                  </Card>
                ))}
              </div>
            </Card>
          </div>
        );

      case 'revenue':
        return (
          <div className="space-y-6">
            <Card className="p-6 border-2 border-gray-200">
              <h3 className="text-2xl font-bold text-gray-900 mb-6">Revenue Overview</h3>

              <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <Card className="p-6 bg-gradient-to-br from-green-50 to-emerald-50 border-2 border-green-200">
                  <DollarSign className="h-8 w-8 text-green-600 mb-2" />
                  <p className="text-sm text-gray-600 mb-1">Total Revenue (YTD)</p>
                  <p className="text-3xl font-bold text-gray-900">$33,400</p>
                  <p className="text-sm text-green-600 mt-2">+18% vs last year</p>
                </Card>

                <Card className="p-6 bg-gradient-to-br from-blue-50 to-indigo-50 border-2 border-blue-200">
                  <Ticket className="h-8 w-8 text-blue-600 mb-2" />
                  <p className="text-sm text-gray-600 mb-1">Total Tickets</p>
                  <p className="text-3xl font-bold text-gray-900">165</p>
                  <p className="text-sm text-blue-600 mt-2">58 this month</p>
                </Card>

                <Card className="p-6 bg-gradient-to-br from-purple-50 to-pink-50 border-2 border-purple-200">
                  <TrendingUp className="h-8 w-8 text-purple-600 mb-2" />
                  <p className="text-sm text-gray-600 mb-1">Avg Ticket Value</p>
                  <p className="text-3xl font-bold text-gray-900">$202</p>
                  <p className="text-sm text-purple-600 mt-2">+12% vs last month</p>
                </Card>
              </div>

              <div className="overflow-x-auto">
                <table className="w-full">
                  <thead>
                    <tr className="border-b-2 border-gray-200">
                      <th className="text-left py-4 px-4 text-sm font-semibold text-gray-700">
                        Period
                      </th>
                      <th className="text-left py-4 px-4 text-sm font-semibold text-gray-700">
                        Revenue
                      </th>
                      <th className="text-left py-4 px-4 text-sm font-semibold text-gray-700">
                        Tickets
                      </th>
                      <th className="text-left py-4 px-4 text-sm font-semibold text-gray-700">
                        Avg Ticket
                      </th>
                      <th className="text-left py-4 px-4 text-sm font-semibold text-gray-700">
                        Growth
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    {revenueData.map((data, idx) => (
                      <tr key={idx} className="border-b border-gray-100">
                        <td className="py-4 px-4 font-medium text-gray-900">{data.month}</td>
                        <td className="py-4 px-4 text-gray-900 font-semibold">
                          ${data.revenue.toLocaleString()}
                        </td>
                        <td className="py-4 px-4 text-gray-700">{data.tickets}</td>
                        <td className="py-4 px-4 text-gray-700">${data.avgTicket}</td>
                        <td className="py-4 px-4">
                          <Badge className="bg-green-50 text-green-600 border-green-200">
                            +{idx === 0 ? '8' : idx === 1 ? '46' : '46'}%
                          </Badge>
                        </td>
                      </tr>
                    ))}
                  </tbody>
                </table>
              </div>
            </Card>

            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
              <Card className="p-6 border-2 border-gray-200">
                <h4 className="font-bold text-gray-900 mb-4">Revenue by Service Tier</h4>
                <div className="space-y-4">
                  {[
                    { tier: 'Basic', revenue: '$4,200', percentage: 34, count: 42 },
                    { tier: 'Standard', revenue: '$6,150', percentage: 49, count: 38 },
                    { tier: 'Advanced', revenue: '$2,100', percentage: 17, count: 12 },
                  ].map((item) => (
                    <div key={item.tier}>
                      <div className="flex justify-between mb-2">
                        <span className="text-sm font-medium text-gray-700">{item.tier}</span>
                        <span className="text-sm font-semibold text-gray-900">
                          {item.revenue} ({item.count} tickets)
                        </span>
                      </div>
                      <div className="w-full bg-gray-200 rounded-full h-2">
                        <div
                          className="bg-gradient-to-r from-purple-600 to-purple-500 h-2 rounded-full"
                          style={{ width: `${item.percentage}%` }}
                        ></div>
                      </div>
                    </div>
                  ))}
                </div>
              </Card>

              <Card className="p-6 border-2 border-gray-200">
                <h4 className="font-bold text-gray-900 mb-4">Top Categories</h4>
                <div className="space-y-4">
                  {[
                    { category: 'WordPress Core', revenue: '$5,200', count: 48 },
                    { category: 'Security', revenue: '$3,800', count: 28 },
                    { category: 'Performance', revenue: '$2,100', count: 35 },
                    { category: 'WooCommerce', revenue: '$1,350', count: 9 },
                  ].map((item) => (
                    <div key={item.category} className="flex justify-between items-center">
                      <div>
                        <p className="font-medium text-gray-900">{item.category}</p>
                        <p className="text-xs text-gray-500">{item.count} tickets</p>
                      </div>
                      <p className="font-bold text-gray-900">{item.revenue}</p>
                    </div>
                  ))}
                </div>
              </Card>
            </div>
          </div>
        );

      case 'analytics':
        return (
          <div className="space-y-6">
            <Card className="p-6 border-2 border-gray-200">
              <h3 className="text-2xl font-bold text-gray-900 mb-6">Analytics & Reports</h3>
              
              <Tabs defaultValue="performance">
                <TabsList className="mb-6">
                  <TabsTrigger value="performance">Performance</TabsTrigger>
                  <TabsTrigger value="satisfaction">Satisfaction</TabsTrigger>
                  <TabsTrigger value="efficiency">Efficiency</TabsTrigger>
                </TabsList>

                <TabsContent value="performance" className="space-y-6">
                  <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <Card className="p-6 bg-blue-50 border-2 border-blue-200">
                      <Clock className="h-8 w-8 text-blue-600 mb-2" />
                      <p className="text-sm text-gray-600 mb-1">Avg First Response</p>
                      <p className="text-3xl font-bold text-gray-900">1.2hrs</p>
                      <p className="text-sm text-green-600 mt-2">15% faster than target</p>
                    </Card>

                    <Card className="p-6 bg-green-50 border-2 border-green-200">
                      <CheckCircle className="h-8 w-8 text-green-600 mb-2" />
                      <p className="text-sm text-gray-600 mb-1">Resolution Rate</p>
                      <p className="text-3xl font-bold text-gray-900">98%</p>
                      <p className="text-sm text-green-600 mt-2">Excellent performance</p>
                    </Card>

                    <Card className="p-6 bg-amber-50 border-2 border-amber-200">
                      <TrendingUp className="h-8 w-8 text-amber-600 mb-2" />
                      <p className="text-sm text-gray-600 mb-1">Avg Resolution Time</p>
                      <p className="text-3xl font-bold text-gray-900">4.5hrs</p>
                      <p className="text-sm text-amber-600 mt-2">Meets SLA targets</p>
                    </Card>
                  </div>
                </TabsContent>

                <TabsContent value="satisfaction">
                  <div className="text-center py-12">
                    <p className="text-gray-500">Customer satisfaction metrics coming soon...</p>
                  </div>
                </TabsContent>

                <TabsContent value="efficiency">
                  <div className="text-center py-12">
                    <p className="text-gray-500">Team efficiency metrics coming soon...</p>
                  </div>
                </TabsContent>
              </Tabs>
            </Card>
          </div>
        );

      case 'notifications':
        return (
          <div className="space-y-6">
            <Card className="p-6 border-2 border-gray-200">
              <h3 className="text-2xl font-bold text-gray-900 mb-6">Notifications</h3>
              <div className="space-y-4">
                {[
                  {
                    type: 'urgent',
                    title: 'Critical Ticket Deadline Approaching',
                    message: 'TKT-1234 has 45 minutes until deadline',
                    time: '5 mins ago',
                  },
                  {
                    type: 'info',
                    title: 'New Client Registration',
                    message: 'Emma Wilson just signed up for Premium plan',
                    time: '25 mins ago',
                  },
                  {
                    type: 'success',
                    title: 'Payment Received',
                    message: 'Payment of $79 received from Sarah Chen',
                    time: '1 hour ago',
                  },
                  {
                    type: 'warning',
                    title: 'Unassigned Tickets',
                    message: '3 tickets are waiting for assignment',
                    time: '2 hours ago',
                  },
                  {
                    type: 'info',
                    title: 'Team Member Update',
                    message: 'Mike R. completed 5 tickets today',
                    time: '3 hours ago',
                  },
                ].map((notification, idx) => (
                  <Card
                    key={idx}
                    className={`p-4 border-l-4 ${
                      notification.type === 'urgent'
                        ? 'border-l-red-500 bg-red-50'
                        : notification.type === 'success'
                        ? 'border-l-green-500 bg-green-50'
                        : notification.type === 'warning'
                        ? 'border-l-yellow-500 bg-yellow-50'
                        : 'border-l-blue-500 bg-blue-50'
                    }`}
                  >
                    <div className="flex justify-between items-start">
                      <div className="flex-1">
                        <h4 className="font-semibold text-gray-900">{notification.title}</h4>
                        <p className="text-sm text-gray-700 mt-1">{notification.message}</p>
                        <p className="text-xs text-gray-500 mt-2">{notification.time}</p>
                      </div>
                      <Button variant="ghost" size="icon" className="h-8 w-8">
                        <X className="h-4 w-4" />
                      </Button>
                    </div>
                  </Card>
                ))}
              </div>
            </Card>
          </div>
        );

      case 'settings':
        return (
          <div className="space-y-6">
            <Card className="p-6 border-2 border-gray-200">
              <h3 className="text-2xl font-bold text-gray-900 mb-6">Platform Settings</h3>
              
              <Tabs defaultValue="general">
                <TabsList className="mb-6">
                  <TabsTrigger value="general">General</TabsTrigger>
                  <TabsTrigger value="pricing">Pricing</TabsTrigger>
                  <TabsTrigger value="notifications">Notifications</TabsTrigger>
                  <TabsTrigger value="integrations">Integrations</TabsTrigger>
                </TabsList>

                <TabsContent value="general" className="space-y-6">
                  <div className="space-y-4">
                    <div>
                      <Label>Platform Name</Label>
                      <Input defaultValue="Aakaari" className="mt-2" />
                    </div>
                    <div>
                      <Label>Support Email</Label>
                      <Input defaultValue="support@aakaari.com" className="mt-2" />
                    </div>
                    <div>
                      <Label>Business Hours</Label>
                      <Input defaultValue="24/7 Support Available" className="mt-2" />
                    </div>
                    <Button className="bg-gradient-to-r from-purple-600 to-purple-500">
                      Save Changes
                    </Button>
                  </div>
                </TabsContent>

                <TabsContent value="pricing">
                  <div className="text-center py-12">
                    <p className="text-gray-500">Pricing configuration coming soon...</p>
                  </div>
                </TabsContent>

                <TabsContent value="notifications">
                  <div className="text-center py-12">
                    <p className="text-gray-500">Notification settings coming soon...</p>
                  </div>
                </TabsContent>

                <TabsContent value="integrations">
                  <div className="text-center py-12">
                    <p className="text-gray-500">Integration settings coming soon...</p>
                  </div>
                </TabsContent>
              </Tabs>
            </Card>
          </div>
        );

      default:
        return null;
    }
  };

  return (
    <div className="min-h-screen bg-gray-50">
      <div className="flex">
        {/* Sidebar - Desktop */}
        <aside className="hidden lg:flex w-64 flex-col fixed left-0 top-16 h-[calc(100vh-4rem)] bg-white border-r border-gray-200">
          {/* Admin Profile */}
          <div className="p-6 border-b border-gray-200">
            <div className="flex items-center">
              <Avatar className="h-12 w-12 mr-3">
                <AvatarFallback className="bg-gradient-to-br from-purple-600 to-purple-500 text-white">
                  AD
                </AvatarFallback>
              </Avatar>
              <div className="flex-1">
                <p className="font-medium text-gray-900">Admin</p>
                <p className="text-sm text-gray-600">admin@aakaari.com</p>
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
                  className={`w-full flex items-center px-4 py-3 rounded-xl text-sm transition-colors ${
                    activeTab === item.id
                      ? 'bg-gradient-to-r from-purple-600 to-purple-500 text-white shadow-lg shadow-purple-500/30'
                      : 'text-gray-700 hover:bg-gray-100'
                  }`}
                >
                  <item.icon className="h-5 w-5 mr-3" />
                  {item.label}
                  {item.badge && (
                    <Badge
                      className={`ml-auto ${
                        activeTab === item.id
                          ? 'bg-white text-purple-600'
                          : 'bg-red-500 text-white'
                      }`}
                    >
                      {item.badge}
                    </Badge>
                  )}
                </button>
              ))}
            </div>
          </nav>

          {/* Logout */}
          <div className="p-4 border-t border-gray-200">
            <Button
              variant="ghost"
              onClick={onLogout}
              className="w-full justify-start text-red-600 hover:text-red-700 hover:bg-red-50"
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
            <h1 className="text-2xl font-bold text-gray-900">Admin Dashboard</h1>
            <Button
              variant="ghost"
              size="icon"
              onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
            >
              {mobileMenuOpen ? <X className="h-6 w-6" /> : <Menu className="h-6 w-6" />}
            </Button>
          </div>

          {/* Mobile Menu */}
          {mobileMenuOpen && (
            <div className="lg:hidden mb-6 bg-white border border-gray-200 rounded-xl p-4">
              <div className="flex items-center mb-4 pb-4 border-b border-gray-200">
                <Avatar className="h-10 w-10 mr-3">
                  <AvatarFallback className="bg-gradient-to-br from-purple-600 to-purple-500 text-white">
                    AD
                  </AvatarFallback>
                </Avatar>
                <div>
                  <p className="font-medium text-gray-900">Admin</p>
                  <p className="text-sm text-gray-600">admin@aakaari.com</p>
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
                    className={`w-full flex items-center px-3 py-2 rounded-xl text-sm transition-colors ${
                      activeTab === item.id
                        ? 'bg-gradient-to-r from-purple-600 to-purple-500 text-white'
                        : 'text-gray-700 hover:bg-gray-100'
                    }`}
                  >
                    <item.icon className="h-5 w-5 mr-3" />
                    {item.label}
                  </button>
                ))}
                <button
                  onClick={onLogout}
                  className="w-full flex items-center px-3 py-2 rounded-xl text-sm text-red-600 hover:bg-red-50"
                >
                  <LogOut className="h-5 w-5 mr-3" />
                  Logout
                </button>
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
