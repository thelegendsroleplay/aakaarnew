import { Card, CardContent, CardDescription, CardHeader, CardTitle } from './ui/card';
import { Badge } from './ui/badge';
import { Button } from './ui/button';
import { Progress } from './ui/progress';
import { Tabs, TabsContent, TabsList, TabsTrigger } from './ui/tabs';
import {
  BarChart,
  Bar,
  XAxis,
  YAxis,
  CartesianGrid,
  Tooltip,
  ResponsiveContainer,
  PieChart,
  Pie,
  Cell,
} from 'recharts';
import {
  Ticket,
  Clock,
  CheckCircle,
  AlertCircle,
  MessageSquare,
  Calendar,
  DollarSign,
  TrendingUp,
  User,
  Settings,
  FileText,
  Shield,
} from 'lucide-react';

interface DashboardOverviewProps {
  onNavigate: (page: string) => void;
}

export function DashboardOverview({ onNavigate }: DashboardOverviewProps) {
  const stats = [
    {
      title: 'Open Tickets',
      value: '3',
      icon: Ticket,
      color: 'text-blue-600',
      bgColor: 'bg-blue-50',
    },
    {
      title: 'In Progress',
      value: '2',
      icon: Clock,
      color: 'text-orange-600',
      bgColor: 'bg-orange-50',
    },
    {
      title: 'Completed',
      value: '12',
      icon: CheckCircle,
      color: 'text-green-600',
      bgColor: 'bg-green-50',
    },
    {
      title: 'Active Plans',
      value: '1',
      icon: Calendar,
      color: 'text-purple-600',
      bgColor: 'bg-purple-50',
    },
  ];

  const recentTickets = [
    {
      id: '#TKT-1234',
      title: 'Plugin conflict causing 500 error',
      status: 'in-progress',
      priority: 'high',
      engineer: 'John Smith',
      created: '2 days ago',
      updated: '3 hours ago',
    },
    {
      id: '#TKT-1235',
      title: 'Slow page load times',
      status: 'open',
      priority: 'medium',
      engineer: 'Unassigned',
      created: '1 day ago',
      updated: '1 day ago',
    },
    {
      id: '#TKT-1232',
      title: 'Contact form not sending emails',
      status: 'completed',
      priority: 'high',
      engineer: 'Sarah Johnson',
      created: '5 days ago',
      updated: '2 days ago',
    },
  ];

  const upcomingTasks = [
    {
      title: 'WordPress core update to 6.5',
      date: 'Feb 5, 2026',
      type: 'Maintenance',
    },
    {
      title: 'Security scan scheduled',
      date: 'Feb 8, 2026',
      type: 'Security',
    },
    {
      title: 'Monthly backup verification',
      date: 'Feb 10, 2026',
      type: 'Backup',
    },
  ];

  const ticketData = [
    { month: 'Sep', tickets: 4 },
    { month: 'Oct', tickets: 6 },
    { month: 'Nov', tickets: 5 },
    { month: 'Dec', tickets: 8 },
    { month: 'Jan', tickets: 7 },
  ];

  const statusData = [
    { name: 'Completed', value: 12, color: '#10b981' },
    { name: 'In Progress', value: 2, color: '#f59e0b' },
    { name: 'Open', value: 3, color: '#0066FF' },
  ];

  const getStatusColor = (status: string) => {
    switch (status) {
      case 'completed':
        return 'bg-green-100 text-green-800';
      case 'in-progress':
        return 'bg-orange-100 text-orange-800';
      case 'open':
        return 'bg-blue-100 text-blue-800';
      default:
        return 'bg-gray-100 text-gray-800';
    }
  };

  const getPriorityColor = (priority: string) => {
    switch (priority) {
      case 'high':
        return 'bg-red-100 text-red-800';
      case 'medium':
        return 'bg-yellow-100 text-yellow-800';
      case 'low':
        return 'bg-gray-100 text-gray-800';
      default:
        return 'bg-gray-100 text-gray-800';
    }
  };

  return (
    <div className="space-y-6">
      {/* Stats Grid */}
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {stats.map((stat, index) => (
          <Card key={index}>
            <CardContent className="p-6">
              <div className="flex items-center justify-between">
                <div>
                  <p className="text-sm text-muted-foreground mb-1">
                    {stat.title}
                  </p>
                  <p className="text-3xl font-bold">{stat.value}</p>
                </div>
                <div
                  className={`flex h-12 w-12 items-center justify-center rounded-lg ${stat.bgColor}`}
                >
                  <stat.icon className={`h-6 w-6 ${stat.color}`} />
                </div>
              </div>
            </CardContent>
          </Card>
        ))}
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {/* Recent Tickets */}
        <Card className="lg:col-span-2">
          <CardHeader>
            <div className="flex items-center justify-between">
              <CardTitle>Recent Tickets</CardTitle>
              <Button variant="ghost" size="sm">
                View All
              </Button>
            </div>
          </CardHeader>
          <CardContent>
            <div className="space-y-4">
              {recentTickets.map((ticket) => (
                <div
                  key={ticket.id}
                  className="flex items-start justify-between p-4 border rounded-lg hover:bg-accent/50 transition-colors cursor-pointer"
                >
                  <div className="flex-1">
                    <div className="flex items-center gap-2 mb-2">
                      <span className="text-sm font-mono text-muted-foreground">
                        {ticket.id}
                      </span>
                      <Badge
                        variant="secondary"
                        className={getStatusColor(ticket.status)}
                      >
                        {ticket.status}
                      </Badge>
                      <Badge
                        variant="outline"
                        className={getPriorityColor(ticket.priority)}
                      >
                        {ticket.priority}
                      </Badge>
                    </div>
                    <h4 className="mb-2">{ticket.title}</h4>
                    <div className="flex items-center gap-4 text-sm text-muted-foreground">
                      <span className="flex items-center">
                        <User className="h-3 w-3 mr-1" />
                        {ticket.engineer}
                      </span>
                      <span className="flex items-center">
                        <Clock className="h-3 w-3 mr-1" />
                        Updated {ticket.updated}
                      </span>
                    </div>
                  </div>
                  <Button variant="ghost" size="sm">
                    View
                  </Button>
                </div>
              ))}
            </div>
          </CardContent>
        </Card>

        {/* Upcoming Tasks */}
        <Card>
          <CardHeader>
            <CardTitle>Upcoming Tasks</CardTitle>
            <CardDescription>Scheduled maintenance & updates</CardDescription>
          </CardHeader>
          <CardContent>
            <div className="space-y-4">
              {upcomingTasks.map((task, index) => (
                <div key={index} className="flex items-start">
                  <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10 mr-3 flex-shrink-0">
                    <Calendar className="h-5 w-5 text-primary" />
                  </div>
                  <div>
                    <p className="font-medium text-sm">{task.title}</p>
                    <p className="text-xs text-muted-foreground">{task.date}</p>
                    <Badge variant="outline" className="text-xs mt-1">
                      {task.type}
                    </Badge>
                  </div>
                </div>
              ))}
            </div>
          </CardContent>
        </Card>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {/* Ticket Trends */}
        <Card>
          <CardHeader>
            <CardTitle>Ticket Trends</CardTitle>
            <CardDescription>Last 5 months</CardDescription>
          </CardHeader>
          <CardContent>
            <ResponsiveContainer width="100%" height={250}>
              <BarChart data={ticketData}>
                <CartesianGrid strokeDasharray="3 3" stroke="#f0f0f0" />
                <XAxis dataKey="month" stroke="#64748b" />
                <YAxis stroke="#64748b" />
                <Tooltip />
                <Bar dataKey="tickets" fill="#0066FF" radius={[4, 4, 0, 0]} />
              </BarChart>
            </ResponsiveContainer>
          </CardContent>
        </Card>

        {/* Status Distribution */}
        <Card>
          <CardHeader>
            <CardTitle>Ticket Status</CardTitle>
            <CardDescription>Distribution of all tickets</CardDescription>
          </CardHeader>
          <CardContent>
            <div className="flex items-center justify-between">
              <ResponsiveContainer width="50%" height={200}>
                <PieChart>
                  <Pie
                    data={statusData}
                    cx="50%"
                    cy="50%"
                    innerRadius={60}
                    outerRadius={80}
                    paddingAngle={5}
                    dataKey="value"
                  >
                    {statusData.map((entry, index) => (
                      <Cell key={`cell-${index}`} fill={entry.color} />
                    ))}
                  </Pie>
                </PieChart>
              </ResponsiveContainer>
              <div className="space-y-2">
                {statusData.map((entry, index) => (
                  <div key={index} className="flex items-center">
                    <div
                      className="h-3 w-3 rounded-full mr-2"
                      style={{ backgroundColor: entry.color }}
                    />
                    <span className="text-sm">{entry.name}</span>
                    <span className="text-sm font-medium ml-auto">
                      {entry.value}
                    </span>
                  </div>
                ))}
              </div>
            </div>
          </CardContent>
        </Card>
      </div>

      {/* Active Plan */}
      <Card className="border-primary">
        <CardHeader>
          <div className="flex items-center justify-between">
            <div>
              <CardTitle>Active Maintenance Plan</CardTitle>
              <CardDescription>Pro Plan - Renews Feb 28, 2026</CardDescription>
            </div>
            <Badge className="bg-primary">Active</Badge>
          </div>
        </CardHeader>
        <CardContent>
          <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
              <p className="text-sm text-muted-foreground mb-2">
                Support Hours Used
              </p>
              <Progress value={60} className="mb-2" />
              <p className="text-sm font-medium">3 of 5 hours used</p>
            </div>
            <div>
              <p className="text-sm text-muted-foreground mb-2">
                Content Updates
              </p>
              <Progress value={20} className="mb-2" />
              <p className="text-sm font-medium">12 of 60 minutes used</p>
            </div>
            <div className="flex items-center">
              <Button variant="outline" className="w-full">
                Upgrade Plan
              </Button>
            </div>
          </div>
        </CardContent>
      </Card>

      {/* Quick Actions */}
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <Button
          variant="outline"
          className="h-auto py-4 flex-col"
          onClick={() => onNavigate('fix-an-issue')}
        >
          <Ticket className="h-6 w-6 mb-2" />
          <span>Submit New Ticket</span>
        </Button>
        <Button variant="outline" className="h-auto py-4 flex-col">
          <MessageSquare className="h-6 w-6 mb-2" />
          <span>Start Live Chat</span>
        </Button>
        <Button variant="outline" className="h-auto py-4 flex-col">
          <FileText className="h-6 w-6 mb-2" />
          <span>View Invoices</span>
        </Button>
        <Button variant="outline" className="h-auto py-4 flex-col">
          <Shield className="h-6 w-6 mb-2" />
          <span>Manage Access</span>
        </Button>
      </div>
    </div>
  );
}
