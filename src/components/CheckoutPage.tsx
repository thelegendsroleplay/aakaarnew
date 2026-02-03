import { useState } from 'react';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from './ui/card';
import { Button } from './ui/button';
import { Input } from './ui/input';
import { Label } from './ui/label';
import { Badge } from './ui/badge';
import { Separator } from './ui/separator';
import { Checkbox } from './ui/checkbox';
import {
  CreditCard,
  Lock,
  ShieldCheck,
  CheckCircle,
  Tag,
  ArrowLeft,
} from 'lucide-react';
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from './ui/select';

interface CheckoutPageProps {
  onNavigate: (page: string) => void;
}

export function CheckoutPage({ onNavigate }: CheckoutPageProps) {
  const [paymentMethod, setPaymentMethod] = useState('card');
  const [couponCode, setCouponCode] = useState('');
  const [couponApplied, setCouponApplied] = useState(false);

  const orderDetails = {
    item: 'Fix-an-Issue: Plugin conflict causing 500 error',
    itemPrice: 149,
    priority: 0,
    discount: couponApplied ? 15 : 0,
  };

  const subtotal = orderDetails.itemPrice + orderDetails.priority;
  const discount = (subtotal * orderDetails.discount) / 100;
  const total = subtotal - discount;

  const handleApplyCoupon = () => {
    if (couponCode.toLowerCase() === 'welcome10') {
      setCouponApplied(true);
    }
  };

  return (
    <div className="w-full py-12 bg-muted/30">
      <div className="container mx-auto px-4">
        {/* Back Button */}
        <Button
          variant="ghost"
          className="mb-6"
          onClick={() => onNavigate('fix-an-issue')}
        >
          <ArrowLeft className="mr-2 h-4 w-4" />
          Back to Form
        </Button>

        <div className="max-w-6xl mx-auto">
          <div className="text-center mb-8">
            <h1 className="text-3xl md:text-4xl mb-2">Secure Checkout</h1>
            <p className="text-muted-foreground">
              Complete your order and get your issue fixed
            </p>
          </div>

          <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {/* Payment Form */}
            <div className="lg:col-span-2 space-y-6">
              {/* Contact Information */}
              <Card>
                <CardHeader>
                  <CardTitle>Contact Information</CardTitle>
                  <CardDescription>
                    We'll send order confirmation to this email
                  </CardDescription>
                </CardHeader>
                <CardContent className="space-y-4">
                  <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div className="space-y-2">
                      <Label htmlFor="firstName">First Name</Label>
                      <Input id="firstName" placeholder="John" />
                    </div>
                    <div className="space-y-2">
                      <Label htmlFor="lastName">Last Name</Label>
                      <Input id="lastName" placeholder="Doe" />
                    </div>
                  </div>
                  <div className="space-y-2">
                    <Label htmlFor="email">Email Address</Label>
                    <Input
                      id="email"
                      type="email"
                      placeholder="john@example.com"
                    />
                  </div>
                  <div className="space-y-2">
                    <Label htmlFor="phone">Phone Number</Label>
                    <Input id="phone" type="tel" placeholder="+1 (555) 000-0000" />
                  </div>
                </CardContent>
              </Card>

              {/* Payment Method */}
              <Card>
                <CardHeader>
                  <CardTitle>Payment Method</CardTitle>
                  <CardDescription>
                    Choose how you'd like to pay
                  </CardDescription>
                </CardHeader>
                <CardContent className="space-y-6">
                  {/* Payment Options */}
                  <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <button
                      onClick={() => setPaymentMethod('card')}
                      className={`p-4 border-2 rounded-lg transition-colors ${
                        paymentMethod === 'card'
                          ? 'border-primary bg-primary/5'
                          : 'border-border hover:border-primary/50'
                      }`}
                    >
                      <CreditCard className="h-6 w-6 mx-auto mb-2" />
                      <p className="text-sm font-medium">Credit Card</p>
                    </button>
                    <button
                      onClick={() => setPaymentMethod('paypal')}
                      className={`p-4 border-2 rounded-lg transition-colors ${
                        paymentMethod === 'paypal'
                          ? 'border-primary bg-primary/5'
                          : 'border-border hover:border-primary/50'
                      }`}
                    >
                      <div className="h-6 w-6 mx-auto mb-2 flex items-center justify-center font-bold text-primary">
                        PP
                      </div>
                      <p className="text-sm font-medium">PayPal</p>
                    </button>
                    <button
                      onClick={() => setPaymentMethod('bank')}
                      className={`p-4 border-2 rounded-lg transition-colors ${
                        paymentMethod === 'bank'
                          ? 'border-primary bg-primary/5'
                          : 'border-border hover:border-primary/50'
                      }`}
                    >
                      <div className="h-6 w-6 mx-auto mb-2 flex items-center justify-center font-bold text-primary">
                        $
                      </div>
                      <p className="text-sm font-medium">Bank Transfer</p>
                    </button>
                  </div>

                  {/* Credit Card Form */}
                  {paymentMethod === 'card' && (
                    <div className="space-y-4">
                      <div className="space-y-2">
                        <Label htmlFor="cardNumber">Card Number</Label>
                        <Input
                          id="cardNumber"
                          placeholder="1234 5678 9012 3456"
                          maxLength={19}
                        />
                      </div>
                      <div className="grid grid-cols-2 gap-4">
                        <div className="space-y-2">
                          <Label htmlFor="expiry">Expiry Date</Label>
                          <Input id="expiry" placeholder="MM/YY" maxLength={5} />
                        </div>
                        <div className="space-y-2">
                          <Label htmlFor="cvv">CVV</Label>
                          <Input
                            id="cvv"
                            type="password"
                            placeholder="123"
                            maxLength={4}
                          />
                        </div>
                      </div>
                      <div className="space-y-2">
                        <Label htmlFor="cardName">Name on Card</Label>
                        <Input id="cardName" placeholder="John Doe" />
                      </div>
                    </div>
                  )}

                  {paymentMethod === 'paypal' && (
                    <div className="text-center py-8">
                      <p className="text-muted-foreground mb-4">
                        You will be redirected to PayPal to complete your payment
                      </p>
                      <Button variant="outline" className="w-full max-w-xs">
                        Continue with PayPal
                      </Button>
                    </div>
                  )}

                  {paymentMethod === 'bank' && (
                    <div className="bg-muted/50 p-4 rounded-lg">
                      <p className="text-sm mb-4">
                        Bank transfer details will be sent to your email after
                        placing the order. Work begins after payment confirmation.
                      </p>
                      <div className="space-y-2 text-sm">
                        <p>
                          <span className="font-medium">Bank:</span> Example Bank
                        </p>
                        <p>
                          <span className="font-medium">Account:</span> 1234567890
                        </p>
                        <p>
                          <span className="font-medium">Routing:</span> 987654321
                        </p>
                      </div>
                    </div>
                  )}
                </CardContent>
              </Card>

              {/* Billing Address */}
              <Card>
                <CardHeader>
                  <CardTitle>Billing Address</CardTitle>
                </CardHeader>
                <CardContent className="space-y-4">
                  <div className="space-y-2">
                    <Label htmlFor="country">Country</Label>
                    <Select>
                      <SelectTrigger>
                        <SelectValue placeholder="Select country" />
                      </SelectTrigger>
                      <SelectContent>
                        <SelectItem value="us">United States</SelectItem>
                        <SelectItem value="ca">Canada</SelectItem>
                        <SelectItem value="uk">United Kingdom</SelectItem>
                        <SelectItem value="au">Australia</SelectItem>
                      </SelectContent>
                    </Select>
                  </div>
                  <div className="space-y-2">
                    <Label htmlFor="address">Street Address</Label>
                    <Input id="address" placeholder="123 Main Street" />
                  </div>
                  <div className="grid grid-cols-2 gap-4">
                    <div className="space-y-2">
                      <Label htmlFor="city">City</Label>
                      <Input id="city" placeholder="San Francisco" />
                    </div>
                    <div className="space-y-2">
                      <Label htmlFor="zip">ZIP Code</Label>
                      <Input id="zip" placeholder="94105" />
                    </div>
                  </div>
                </CardContent>
              </Card>
            </div>

            {/* Order Summary */}
            <div className="lg:col-span-1">
              <Card className="sticky top-24">
                <CardHeader>
                  <CardTitle>Order Summary</CardTitle>
                </CardHeader>
                <CardContent className="space-y-4">
                  {/* Item */}
                  <div>
                    <div className="flex justify-between mb-1">
                      <span className="text-sm font-medium">Service</span>
                      <span className="text-sm font-medium">
                        ${orderDetails.itemPrice}
                      </span>
                    </div>
                    <p className="text-xs text-muted-foreground">
                      {orderDetails.item}
                    </p>
                  </div>

                  <Separator />

                  {/* Coupon */}
                  <div>
                    <Label htmlFor="coupon" className="text-sm mb-2 block">
                      Have a coupon?
                    </Label>
                    <div className="flex gap-2">
                      <Input
                        id="coupon"
                        placeholder="Enter code"
                        value={couponCode}
                        onChange={(e) => setCouponCode(e.target.value)}
                        disabled={couponApplied}
                      />
                      <Button
                        variant="outline"
                        onClick={handleApplyCoupon}
                        disabled={couponApplied}
                      >
                        Apply
                      </Button>
                    </div>
                    {couponApplied && (
                      <div className="flex items-center text-sm text-green-600 mt-2">
                        <CheckCircle className="h-4 w-4 mr-1" />
                        Coupon applied!
                      </div>
                    )}
                  </div>

                  <Separator />

                  {/* Pricing Breakdown */}
                  <div className="space-y-2">
                    <div className="flex justify-between text-sm">
                      <span>Subtotal</span>
                      <span>${subtotal.toFixed(2)}</span>
                    </div>
                    {couponApplied && (
                      <div className="flex justify-between text-sm text-green-600">
                        <span>Discount ({orderDetails.discount}%)</span>
                        <span>-${discount.toFixed(2)}</span>
                      </div>
                    )}
                    <Separator />
                    <div className="flex justify-between text-lg font-bold">
                      <span>Total</span>
                      <span className="text-primary">${total.toFixed(2)}</span>
                    </div>
                  </div>

                  {/* Security Badges */}
                  <div className="bg-muted/50 p-4 rounded-lg space-y-2">
                    <div className="flex items-center text-sm">
                      <ShieldCheck className="h-4 w-4 text-green-600 mr-2" />
                      <span>Secure payment processing</span>
                    </div>
                    <div className="flex items-center text-sm">
                      <Lock className="h-4 w-4 text-green-600 mr-2" />
                      <span>256-bit SSL encryption</span>
                    </div>
                    <div className="flex items-center text-sm">
                      <CheckCircle className="h-4 w-4 text-green-600 mr-2" />
                      <span>Money-back guarantee</span>
                    </div>
                  </div>

                  {/* Terms */}
                  <div className="flex items-start space-x-2">
                    <Checkbox id="terms" />
                    <label
                      htmlFor="terms"
                      className="text-xs leading-tight peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                    >
                      I agree to the{' '}
                      <button className="text-primary hover:underline">
                        Terms of Service
                      </button>{' '}
                      and{' '}
                      <button className="text-primary hover:underline">
                        Refund Policy
                      </button>
                    </label>
                  </div>

                  {/* Submit Button */}
                  <Button className="w-full" size="lg">
                    <Lock className="mr-2 h-4 w-4" />
                    Pay ${total.toFixed(2)}
                  </Button>

                  <p className="text-xs text-center text-muted-foreground">
                    Your payment information is secure and encrypted
                  </p>
                </CardContent>
              </Card>

              {/* Guarantee Badge */}
              <Card className="mt-4 bg-primary/5 border-primary/20">
                <CardContent className="p-4 text-center">
                  <ShieldCheck className="h-8 w-8 text-primary mx-auto mb-2" />
                  <h4 className="mb-1">100% Money-Back Guarantee</h4>
                  <p className="text-xs text-muted-foreground">
                    If we can't fix your issue, you get a full refund. No questions
                    asked.
                  </p>
                </CardContent>
              </Card>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
