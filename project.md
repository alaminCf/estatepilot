PROJECT_NAME: London Abason Real Estate Platform
CLIENT: London Abason Ltd.
DEVELOPER: Arif Arman
VERSION: 1.0
PROJECT_TYPE: Web Application (Real Estate Plot Management)

DESCRIPTION:
Laravel-based platform for selling residential and commercial plots.
Users can browse plots, view installment plans, book plots, manage payments,
and receive SMS notifications. Admins manage plots, bookings, payments, users,
and system settings.



--------------------------------------------------
USER_ROLES:
--------------------------------------------------
- User (Customer)
- Agent
- Admin

--------------------------------------------------
FRONTEND_PAGES:
--------------------------------------------------
HOME_PAGE:
- Hero Banner
- Plot Search (Size, Location, Block, Price Range)
- Featured Plots
- Why Choose Section
- Testimonials
- Project Layout Preview
- Contact CTA

PLOT_LISTING_PAGE:
- List/Grid View Toggle
- Filters:
  - Plot Size (Katha)
  - Block
  - Road No
  - Price Range
  - Facing Direction
  - Availability Status
- Sorting:
  - Price Low to High
  - Latest
  - Popular
- Pagination
- Plot Card Fields:
  - Plot No
  - Size (Katha)
  - Block
  - Price
  - Status

PLOT_DETAILS_PAGE:
- Plot No
- Block
- Road No
- Size (Katha)
- Facing Direction
- Total Price
- Booking Money
- Down Payment
- Installment Plan:
  - Monthly / Quarterly
  - Total Installments
  - Payment Schedule
- Plot Map / Layout Image
- Google Maps Location
- Nearby Facilities
- Booking Form
- Related Plots

ABOUT_PAGE:
- Company Overview
- Mission
- Vision

CONTACT_PAGE:
- Contact Form
- Office Address
- Phone
- Email

BLOG_PAGE:
- Blog Listing
- Blog Details
- SEO Optimized Content

--------------------------------------------------
USER_DASHBOARD:
--------------------------------------------------
PROFILE:
- View Profile
- Edit Profile

PAYMENTS:
- Total Balance
- Paid Installments
- Pending Installments
- Next Due Date
- Download PDF Receipts

--------------------------------------------------
ADMIN_PANEL:
--------------------------------------------------
ADMIN_DASHBOARD_METRICS:
- Total Plots
- Available Plots
- Booked Plots
- Sold Plots
- Total Customers
- Total Collections
- Pending Installments
- Upcoming Due Dates
- SMS Statistics

PLOT_MANAGEMENT:
FIELDS:
- plot_no
- size_katha
- block
- road_no
- facing
- price
- booking_money
- down_payment
- installment_structure
- plot_map
- status

ACTIONS:
- Add Plot
- Edit Plot
- Delete Plot

BOOKING_MANAGEMENT:
- Approve Booking
- Edit Booking
- Cancel Booking
- Update Plot Status

PAYMENT_MANAGEMENT:
- Record Payment
- Add Installment Payment
- Mark Overdue
- Generate Statement
- Send Receipt via SMS

USER_MANAGEMENT:
- Create User
- Edit User
- Assign Roles
- Disable User

SITE_SETTINGS:
- Logo
- Branding
- SEO Meta
- Contact Info
- Social Links

--------------------------------------------------
SMS_SYSTEM:
--------------------------------------------------
SMS_EVENTS:
- New Booking Confirmation
- Booking Money Received
- Down Payment Received
- Installment Received
- Pending Installment Reminder
- Next Installment Due
- Overdue Alert
- Plot Registration Update
- Promotional Message
