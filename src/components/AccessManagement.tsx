import { useState } from 'react';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from './ui/card';
import { Button } from './ui/button';
import { Input } from './ui/input';
import { Label } from './ui/label';
import { Badge } from './ui/badge';
import { Switch } from './ui/switch';
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from './ui/table';
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from './ui/dialog';
import {
  Shield,
  Key,
  Eye,
  EyeOff,
  Copy,
  Trash2,
  Plus,
  CheckCircle,
  Clock,
  AlertCircle,
} from 'lucide-react';
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from './ui/select';

export function AccessManagement() {
  const [showPassword, setShowPassword] = useState<{ [key: string]: boolean }>({});
  const [addAccessOpen, setAddAccessOpen] = useState(false);

  const accessCredentials = [
    {
      id: '1',
      type: 'WordPress Admin',
      website: 'mywebsite.com',
      username: 'admin',
      password: '••••••••',
      actualPassword: 'MySecurePass123!',
      status: 'active',
      expires: 'Feb 10, 2026',
      lastUsed: '2 hours ago',
      autoExpire: true,
    },
    {
      id: '2',
      type: 'cPanel',
      website: 'mywebsite.com',
      username: 'cpanel_user',
      password: '••••••••',
      actualPassword: 'CpanelPass456!',
      status: 'active',
      expires: 'Feb 10, 2026',
      lastUsed: '1 day ago',
      autoExpire: true,
    },
    {
      id: '3',
      type: 'FTP',
      website: 'mywebsite.com',
      username: 'ftp_user',
      password: '••••••••',
      actualPassword: 'FtpPass789!',
      status: 'expired',
      expires: 'Jan 28, 2026',
      lastUsed: '5 days ago',
      autoExpire: true,
    },
  ];

  const togglePasswordVisibility = (id: string) => {
    setShowPassword((prev) => ({
      ...prev,
      [id]: !prev[id],
    }));
  };

  const copyToClipboard = (text: string) => {
    navigator.clipboard.writeText(text);
  };

  const getStatusColor = (status: string) => {
    switch (status) {
      case 'active':
        return 'bg-green-100 text-green-800';
      case 'expired':
        return 'bg-red-100 text-red-800';
      case 'revoked':
        return 'bg-gray-100 text-gray-800';
      default:
        return 'bg-gray-100 text-gray-800';
    }
  };

  return (
    <div className="space-y-6">
      {/* Header */}
      <div className="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
          <h2 className="text-2xl font-bold">Access Management</h2>
          <p className="text-muted-foreground">
            Securely manage website access credentials
          </p>
        </div>
        <Dialog open={addAccessOpen} onOpenChange={setAddAccessOpen}>
          <DialogTrigger asChild>
            <Button>
              <Plus className="mr-2 h-4 w-4" />
              Add Credentials
            </Button>
          </DialogTrigger>
          <DialogContent className="max-w-md">
            <DialogHeader>
              <DialogTitle>Add Access Credentials</DialogTitle>
              <DialogDescription>
                Provide secure access for our engineers to fix your issue
              </DialogDescription>
            </DialogHeader>
            <div className="space-y-4 pt-4">
              <div className="space-y-2">
                <Label htmlFor="accessType">Access Type</Label>
                <Select>
                  <SelectTrigger>
                    <SelectValue placeholder="Select type" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectItem value="wp-admin">WordPress Admin</SelectItem>
                    <SelectItem value="cpanel">cPanel</SelectItem>
                    <SelectItem value="ftp">FTP</SelectItem>
                    <SelectItem value="hosting">Hosting Panel</SelectItem>
                    <SelectItem value="cloudflare">Cloudflare</SelectItem>
                  </SelectContent>
                </Select>
              </div>
              <div className="space-y-2">
                <Label htmlFor="website">Website URL</Label>
                <Input id="website" placeholder="https://yourwebsite.com" />
              </div>
              <div className="space-y-2">
                <Label htmlFor="username">Username</Label>
                <Input id="username" placeholder="admin" />
              </div>
              <div className="space-y-2">
                <Label htmlFor="password">Password</Label>
                <Input id="password" type="password" placeholder="••••••••" />
              </div>
              <div className="space-y-2">
                <Label htmlFor="expiryDays">Auto-expire after</Label>
                <Select defaultValue="7">
                  <SelectTrigger>
                    <SelectValue />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectItem value="1">1 day</SelectItem>
                    <SelectItem value="3">3 days</SelectItem>
                    <SelectItem value="7">7 days</SelectItem>
                    <SelectItem value="14">14 days</SelectItem>
                    <SelectItem value="30">30 days</SelectItem>
                  </SelectContent>
                </Select>
              </div>
              <div className="flex items-center space-x-2">
                <Switch id="notify" defaultChecked />
                <Label htmlFor="notify" className="text-sm">
                  Notify me when access expires
                </Label>
              </div>
              <Button className="w-full" onClick={() => setAddAccessOpen(false)}>
                Add Credentials
              </Button>
            </div>
          </DialogContent>
        </Dialog>
      </div>

      {/* Security Notice */}
      <Card className="bg-primary/5 border-primary/20">
        <CardContent className="p-6">
          <div className="flex items-start">
            <Shield className="h-6 w-6 text-primary mr-4 mt-1 flex-shrink-0" />
            <div>
              <h3 className="mb-2">Your Security is Our Priority</h3>
              <ul className="space-y-1 text-sm text-muted-foreground">
                <li>• All credentials are encrypted using 256-bit AES encryption</li>
                <li>• Access automatically expires after work completion</li>
                <li>• Only assigned engineers can view credentials</li>
                <li>• All access attempts are logged and monitored</li>
                <li>• You can revoke access instantly at any time</li>
              </ul>
            </div>
          </div>
        </CardContent>
      </Card>

      {/* Active Credentials */}
      <Card>
        <CardHeader>
          <CardTitle>Saved Credentials</CardTitle>
          <CardDescription>
            Manage access for engineers working on your website
          </CardDescription>
        </CardHeader>
        <CardContent>
          <div className="space-y-4">
            {accessCredentials.map((cred) => (
              <Card key={cred.id} className="border-2">
                <CardContent className="p-6">
                  <div className="flex items-start justify-between mb-4">
                    <div className="flex-1">
                      <div className="flex items-center gap-2 mb-2">
                        <h4>{cred.type}</h4>
                        <Badge
                          variant="secondary"
                          className={getStatusColor(cred.status)}
                        >
                          {cred.status}
                        </Badge>
                      </div>
                      <p className="text-sm text-muted-foreground mb-1">
                        {cred.website}
                      </p>
                      <div className="flex items-center text-xs text-muted-foreground gap-4">
                        <span className="flex items-center">
                          <Clock className="h-3 w-3 mr-1" />
                          Last used: {cred.lastUsed}
                        </span>
                        {cred.status === 'active' && (
                          <span className="flex items-center">
                            <AlertCircle className="h-3 w-3 mr-1" />
                            Expires: {cred.expires}
                          </span>
                        )}
                      </div>
                    </div>
                    <div className="flex gap-2">
                      {cred.status === 'active' && (
                        <Button variant="destructive" size="sm">
                          Revoke
                        </Button>
                      )}
                      <Button
                        variant="ghost"
                        size="icon"
                        onClick={() => {}}
                      >
                        <Trash2 className="h-4 w-4" />
                      </Button>
                    </div>
                  </div>

                  <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                      <Label className="text-xs text-muted-foreground">
                        Username
                      </Label>
                      <div className="flex items-center gap-2 mt-1">
                        <Input
                          value={cred.username}
                          readOnly
                          className="font-mono text-sm"
                        />
                        <Button
                          variant="ghost"
                          size="icon"
                          onClick={() => copyToClipboard(cred.username)}
                        >
                          <Copy className="h-4 w-4" />
                        </Button>
                      </div>
                    </div>
                    <div>
                      <Label className="text-xs text-muted-foreground">
                        Password
                      </Label>
                      <div className="flex items-center gap-2 mt-1">
                        <Input
                          type={showPassword[cred.id] ? 'text' : 'password'}
                          value={
                            showPassword[cred.id]
                              ? cred.actualPassword
                              : cred.password
                          }
                          readOnly
                          className="font-mono text-sm"
                        />
                        <Button
                          variant="ghost"
                          size="icon"
                          onClick={() => togglePasswordVisibility(cred.id)}
                        >
                          {showPassword[cred.id] ? (
                            <EyeOff className="h-4 w-4" />
                          ) : (
                            <Eye className="h-4 w-4" />
                          )}
                        </Button>
                        <Button
                          variant="ghost"
                          size="icon"
                          onClick={() => copyToClipboard(cred.actualPassword)}
                        >
                          <Copy className="h-4 w-4" />
                        </Button>
                      </div>
                    </div>
                  </div>

                  {cred.autoExpire && (
                    <div className="mt-4 flex items-center text-xs text-muted-foreground">
                      <CheckCircle className="h-3 w-3 mr-1 text-green-600" />
                      Auto-expires after ticket closure
                    </div>
                  )}
                </CardContent>
              </Card>
            ))}
          </div>
        </CardContent>
      </Card>

      {/* Access Logs */}
      <Card>
        <CardHeader>
          <CardTitle>Recent Access Activity</CardTitle>
          <CardDescription>
            View who accessed your website and when
          </CardDescription>
        </CardHeader>
        <CardContent>
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>Date & Time</TableHead>
                <TableHead>Engineer</TableHead>
                <TableHead>Access Type</TableHead>
                <TableHead>Action</TableHead>
                <TableHead>IP Address</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              <TableRow>
                <TableCell>Feb 1, 2026 2:30 PM</TableCell>
                <TableCell>Sarah Johnson</TableCell>
                <TableCell>WordPress Admin</TableCell>
                <TableCell>Login</TableCell>
                <TableCell className="font-mono text-sm">192.168.1.1</TableCell>
              </TableRow>
              <TableRow>
                <TableCell>Feb 1, 2026 12:15 PM</TableCell>
                <TableCell>Sarah Johnson</TableCell>
                <TableCell>FTP</TableCell>
                <TableCell>File Upload</TableCell>
                <TableCell className="font-mono text-sm">192.168.1.1</TableCell>
              </TableRow>
              <TableRow>
                <TableCell>Jan 31, 2026 4:45 PM</TableCell>
                <TableCell>John Smith</TableCell>
                <TableCell>cPanel</TableCell>
                <TableCell>Database Access</TableCell>
                <TableCell className="font-mono text-sm">192.168.1.2</TableCell>
              </TableRow>
            </TableBody>
          </Table>
        </CardContent>
      </Card>

      {/* Best Practices */}
      <Card>
        <CardHeader>
          <CardTitle>Security Best Practices</CardTitle>
        </CardHeader>
        <CardContent>
          <div className="space-y-4">
            <div className="flex items-start">
              <Key className="h-5 w-5 text-primary mr-3 mt-0.5" />
              <div>
                <h4 className="mb-1">Change Passwords After Work Completion</h4>
                <p className="text-sm text-muted-foreground">
                  We recommend changing your passwords once the work is completed,
                  even though access auto-expires.
                </p>
              </div>
            </div>
            <div className="flex items-start">
              <Shield className="h-5 w-5 text-primary mr-3 mt-0.5" />
              <div>
                <h4 className="mb-1">Enable Two-Factor Authentication</h4>
                <p className="text-sm text-muted-foreground">
                  Add an extra layer of security to your WordPress admin and hosting
                  accounts.
                </p>
              </div>
            </div>
            <div className="flex items-start">
              <CheckCircle className="h-5 w-5 text-primary mr-3 mt-0.5" />
              <div>
                <h4 className="mb-1">Review Access Logs Regularly</h4>
                <p className="text-sm text-muted-foreground">
                  Check the activity log above to monitor all access to your website.
                </p>
              </div>
            </div>
          </div>
        </CardContent>
      </Card>
    </div>
  );
}
