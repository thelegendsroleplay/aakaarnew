import { useState } from 'react';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from './ui/card';
import { Badge } from './ui/badge';
import { Button } from './ui/button';
import { Input } from './ui/input';
import { Textarea } from './ui/textarea';
import { Avatar, AvatarFallback } from './ui/avatar';
import { ScrollArea } from './ui/scroll-area';
import { Send, Paperclip, Smile, User, Bot } from 'lucide-react';

export function LiveChat() {
  const [messages, setMessages] = useState([
    {
      id: 1,
      sender: 'agent',
      name: 'Sarah Johnson',
      message: 'Hi! I\'m Sarah, your support engineer. How can I help you today?',
      time: '10:23 AM',
    },
    {
      id: 2,
      sender: 'user',
      name: 'You',
      message: 'Hi Sarah! I\'m having an issue with my contact form.',
      time: '10:24 AM',
    },
    {
      id: 3,
      sender: 'agent',
      name: 'Sarah Johnson',
      message: 'I\'d be happy to help! Can you describe what\'s happening with your contact form?',
      time: '10:24 AM',
    },
    {
      id: 4,
      sender: 'user',
      name: 'You',
      message: 'It\'s not sending emails. Users fill out the form but I never receive the submissions.',
      time: '10:25 AM',
    },
    {
      id: 5,
      sender: 'agent',
      name: 'Sarah Johnson',
      message: 'Got it. Let me check your form settings. Can you share which plugin you\'re using for the contact form?',
      time: '10:26 AM',
    },
  ]);

  const [newMessage, setNewMessage] = useState('');

  const handleSendMessage = () => {
    if (newMessage.trim()) {
      setMessages([
        ...messages,
        {
          id: messages.length + 1,
          sender: 'user',
          name: 'You',
          message: newMessage,
          time: new Date().toLocaleTimeString([], {
            hour: '2-digit',
            minute: '2-digit',
          }),
        },
      ]);
      setNewMessage('');

      // Simulate agent response
      setTimeout(() => {
        setMessages((prev) => [
          ...prev,
          {
            id: prev.length + 1,
            sender: 'agent',
            name: 'Sarah Johnson',
            message: 'Let me look into that for you. One moment please.',
            time: new Date().toLocaleTimeString([], {
              hour: '2-digit',
              minute: '2-digit',
            }),
          },
        ]);
      }, 2000);
    }
  };

  return (
    <Card className="h-[calc(100vh-12rem)]">
      <CardHeader className="border-b">
        <div className="flex items-center justify-between">
          <div className="flex items-center">
            <Avatar className="h-10 w-10 mr-3">
              <AvatarFallback className="bg-primary text-white">SJ</AvatarFallback>
            </Avatar>
            <div>
              <CardTitle className="text-lg">Sarah Johnson</CardTitle>
              <CardDescription className="flex items-center">
                <span className="h-2 w-2 bg-green-500 rounded-full mr-2"></span>
                Online
              </CardDescription>
            </div>
          </div>
          <Badge variant="outline">Support Engineer</Badge>
        </div>
      </CardHeader>

      <CardContent className="p-0 flex flex-col h-[calc(100%-5rem)]">
        {/* Messages */}
        <ScrollArea className="flex-1 p-4">
          <div className="space-y-4">
            {messages.map((msg) => (
              <div
                key={msg.id}
                className={`flex ${
                  msg.sender === 'user' ? 'justify-end' : 'justify-start'
                }`}
              >
                <div
                  className={`flex items-start max-w-[70%] ${
                    msg.sender === 'user' ? 'flex-row-reverse' : 'flex-row'
                  }`}
                >
                  <Avatar
                    className={`h-8 w-8 ${
                      msg.sender === 'user' ? 'ml-2' : 'mr-2'
                    }`}
                  >
                    <AvatarFallback
                      className={
                        msg.sender === 'agent'
                          ? 'bg-primary text-white'
                          : 'bg-secondary'
                      }
                    >
                      {msg.sender === 'agent' ? 'SJ' : 'YO'}
                    </AvatarFallback>
                  </Avatar>
                  <div>
                    <div
                      className={`rounded-lg p-3 ${
                        msg.sender === 'user'
                          ? 'bg-primary text-white'
                          : 'bg-muted'
                      }`}
                    >
                      <p className="text-sm">{msg.message}</p>
                    </div>
                    <p className="text-xs text-muted-foreground mt-1">
                      {msg.time}
                    </p>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </ScrollArea>

        {/* Message Input */}
        <div className="p-4 border-t">
          <div className="flex items-end gap-2">
            <Button variant="ghost" size="icon" className="flex-shrink-0">
              <Paperclip className="h-5 w-5" />
            </Button>
            <div className="flex-1">
              <Textarea
                placeholder="Type your message..."
                value={newMessage}
                onChange={(e) => setNewMessage(e.target.value)}
                onKeyDown={(e) => {
                  if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    handleSendMessage();
                  }
                }}
                rows={1}
                className="min-h-[40px] resize-none"
              />
            </div>
            <Button variant="ghost" size="icon" className="flex-shrink-0">
              <Smile className="h-5 w-5" />
            </Button>
            <Button
              size="icon"
              className="flex-shrink-0"
              onClick={handleSendMessage}
            >
              <Send className="h-5 w-5" />
            </Button>
          </div>
          <p className="text-xs text-muted-foreground mt-2">
            Press Enter to send, Shift + Enter for new line
          </p>
        </div>
      </CardContent>
    </Card>
  );
}
