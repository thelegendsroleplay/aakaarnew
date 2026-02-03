import { useState } from 'react';
import { Card, CardContent, CardHeader, CardTitle } from './ui/card';
import { Button } from './ui/button';
import { Badge } from './ui/badge';
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from './ui/table';
import { Input } from './ui/input';
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from './ui/select';
import { Search, Filter, Eye, MessageSquare, Clock, User } from 'lucide-react';

interface TicketsPageProps {
  onNavigate: (page: string) => void;
}

export function TicketsPage({ onNavigate }: TicketsPageProps) {
  const [filterStatus, setFilterStatus] = useState('all');
  const [searchQuery, setSearchQuery] = useState('');

  const tickets = [
    {
      id: '#TKT-1234',
      title: 'Plugin conflict causing 500 error',
      status: 'in-progress',
      priority: 'high',
      engineer: 'John Smith',
      created: 'Jan 30, 2026',
      updated: '3 hours ago',
      messages: 5,
    },
    {
      id: '#TKT-1235',
      title: 'Slow page load times',
      status: 'open',
      priority: 'medium',
      engineer: 'Unassigned',
      created: 'Jan 31, 2026',
      updated: '1 day ago',
      messages: 2,
    },
    {
      id: '#TKT-1233',
      title: 'SSL certificate renewal',
      status: 'waiting',
      priority: 'low',
      engineer: 'Michael Chen',
      created: 'Jan 29, 2026',
      updated: '2 days ago',
      messages: 3,
    },
    {
      id: '#TKT-1232',
      title: 'Contact form not sending emails',
      status: 'completed',
      priority: 'high',
      engineer: 'Sarah Johnson',
      created: 'Jan 27, 2026',
      updated: '2 days ago',
      messages: 8,
    },
    {
      id: '#TKT-1231',
      title: 'Update WordPress to latest version',
      status: 'completed',
      priority: 'medium',
      engineer: 'John Smith',
      created: 'Jan 25, 2026',
      updated: '5 days ago',
      messages: 4,
    },
    {
      id: '#TKT-1230',
      title: 'Add new payment gateway',
      status: 'completed',
      priority: 'medium',
      engineer: 'Emily Rodriguez',
      created: 'Jan 22, 2026',
      updated: '8 days ago',
      messages: 12,
    },
  ];

  const getStatusColor = (status: string) => {
    switch (status) {
      case 'completed':
        return 'bg-green-100 text-green-800';
      case 'in-progress':
        return 'bg-orange-100 text-orange-800';
      case 'open':
        return 'bg-blue-100 text-blue-800';
      case 'waiting':
        return 'bg-yellow-100 text-yellow-800';
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

  const filteredTickets = tickets.filter((ticket) => {
    const matchesStatus = filterStatus === 'all' || ticket.status === filterStatus;
    const matchesSearch =
      searchQuery === '' ||
      ticket.title.toLowerCase().includes(searchQuery.toLowerCase()) ||
      ticket.id.toLowerCase().includes(searchQuery.toLowerCase());
    return matchesStatus && matchesSearch;
  });

  return (
    <div className="space-y-6">
      {/* Header */}
      <div className="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
          <h2 className="text-2xl font-bold">My Tickets</h2>
          <p className="text-muted-foreground">
            View and manage your support tickets
          </p>
        </div>
        <Button onClick={() => onNavigate('fix-an-issue')}>
          Submit New Ticket
        </Button>
      </div>

      {/* Filters */}
      <Card>
        <CardContent className="p-4">
          <div className="flex flex-col md:flex-row gap-4">
            <div className="flex-1 relative">
              <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-muted-foreground" />
              <Input
                placeholder="Search tickets..."
                className="pl-10"
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
              />
            </div>
            <Select value={filterStatus} onValueChange={setFilterStatus}>
              <SelectTrigger className="w-full md:w-[200px]">
                <Filter className="h-4 w-4 mr-2" />
                <SelectValue placeholder="Filter by status" />
              </SelectTrigger>
              <SelectContent>
                <SelectItem value="all">All Status</SelectItem>
                <SelectItem value="open">Open</SelectItem>
                <SelectItem value="in-progress">In Progress</SelectItem>
                <SelectItem value="waiting">Waiting</SelectItem>
                <SelectItem value="completed">Completed</SelectItem>
              </SelectContent>
            </Select>
          </div>
        </CardContent>
      </Card>

      {/* Tickets Table */}
      <Card>
        <CardContent className="p-0">
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>Ticket ID</TableHead>
                <TableHead>Title</TableHead>
                <TableHead>Status</TableHead>
                <TableHead>Priority</TableHead>
                <TableHead>Engineer</TableHead>
                <TableHead>Created</TableHead>
                <TableHead>Updated</TableHead>
                <TableHead className="text-right">Actions</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              {filteredTickets.map((ticket) => (
                <TableRow key={ticket.id} className="cursor-pointer hover:bg-muted/50">
                  <TableCell className="font-mono text-sm">{ticket.id}</TableCell>
                  <TableCell>
                    <div>
                      <p className="font-medium">{ticket.title}</p>
                      <div className="flex items-center text-xs text-muted-foreground mt-1">
                        <MessageSquare className="h-3 w-3 mr-1" />
                        {ticket.messages} messages
                      </div>
                    </div>
                  </TableCell>
                  <TableCell>
                    <Badge variant="secondary" className={getStatusColor(ticket.status)}>
                      {ticket.status}
                    </Badge>
                  </TableCell>
                  <TableCell>
                    <Badge variant="outline" className={getPriorityColor(ticket.priority)}>
                      {ticket.priority}
                    </Badge>
                  </TableCell>
                  <TableCell>
                    <div className="flex items-center">
                      <User className="h-4 w-4 mr-2 text-muted-foreground" />
                      <span className="text-sm">{ticket.engineer}</span>
                    </div>
                  </TableCell>
                  <TableCell className="text-sm">{ticket.created}</TableCell>
                  <TableCell>
                    <div className="flex items-center text-sm">
                      <Clock className="h-4 w-4 mr-1 text-muted-foreground" />
                      {ticket.updated}
                    </div>
                  </TableCell>
                  <TableCell className="text-right">
                    <Button variant="ghost" size="sm">
                      <Eye className="h-4 w-4 mr-2" />
                      View
                    </Button>
                  </TableCell>
                </TableRow>
              ))}
            </TableBody>
          </Table>
        </CardContent>
      </Card>

      {/* Stats */}
      <div className="grid grid-cols-1 md:grid-cols-4 gap-4">
        <Card>
          <CardContent className="p-4">
            <p className="text-sm text-muted-foreground mb-1">Total Tickets</p>
            <p className="text-2xl font-bold">{tickets.length}</p>
          </CardContent>
        </Card>
        <Card>
          <CardContent className="p-4">
            <p className="text-sm text-muted-foreground mb-1">Open</p>
            <p className="text-2xl font-bold text-blue-600">
              {tickets.filter((t) => t.status === 'open').length}
            </p>
          </CardContent>
        </Card>
        <Card>
          <CardContent className="p-4">
            <p className="text-sm text-muted-foreground mb-1">In Progress</p>
            <p className="text-2xl font-bold text-orange-600">
              {tickets.filter((t) => t.status === 'in-progress').length}
            </p>
          </CardContent>
        </Card>
        <Card>
          <CardContent className="p-4">
            <p className="text-sm text-muted-foreground mb-1">Completed</p>
            <p className="text-2xl font-bold text-green-600">
              {tickets.filter((t) => t.status === 'completed').length}
            </p>
          </CardContent>
        </Card>
      </div>
    </div>
  );
}
