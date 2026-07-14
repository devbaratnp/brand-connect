# Brand Connect Landing Page — Design Spec

## Overview

A premium, conversion-focused landing page for Brand Connect — an influencer marketing platform connecting brands with content creators. Design inspired by KlipifyAI's aesthetic: lime + purple dual accents, glassmorphic nav, tight kerning, dark/light section rhythm.

## Tech Stack

- Blade template (`resources/views/welcome.blade.php`)
- Replace existing default Laravel welcome page
- Add route: `GET /` serves the landing page (no auth required)
- Tailwind CSS (already available via Vite in the project)
- No additional dependencies

## Design Tokens

| Token | Value | Usage |
|-------|-------|-------|
| lime | `#c9ff55` | Primary accent, buttons, highlights |
| lime-strong | `#a8ed2e` | Hover states |
| purple | `#7c5cff` | Secondary accent, gradient text |
| purple-deep | `#5b3df5` | Purple emphasis |
| ink | `#161c18` | Primary text, dark sections |
| muted | `#667069` | Secondary text |
| soft | `#f5f7f5` | Card backgrounds |
| paper | `#ffffff` | Page background |
| dark | `#101613` | Dark section backgrounds |
| line | `#e4e9e5` | Borders |

## Typography

- Font: Inter or system sans-serif (via Tailwind)
- Headlines: `font-weight: 800`, letter-spacing `-0.06em` to `-0.08em`
- Hero h1: `clamp(48px, 6vw, 80px)`
- Section h2: `clamp(36px, 4.5vw, 56px)`
- Body: `18px`, line-height `1.65`
- Eyebrow labels: `12px`, uppercase, `font-weight: 700`, `letter-spacing: 0.04em`

## Layout

- Max content width: `1180px`
- Section padding: `max(60px, calc((100vw - 1180px) / 2))` horizontal
- Border-radius on cards: `24px`

## Sections (top to bottom)

### 1. Fixed Header
- Glassmorphic: `rgba(255,255,255,0.86)`, `backdrop-filter: blur(18px)`
- Height: `76px`
- Left: "Brand Connect" logo text
- Center/Right: nav links (How It Works, Features, Pricing) + Login/Register buttons
- Lime primary button for CTA

### 2. Hero
- Full-width, min-height ~800px, centered content
- Background: multi-layer radial gradient — lime top-right, purple left, fading to white
- Subtle noise texture overlay (dot pattern)
- Eyebrow badge: pill-shaped, translucent, "Influencer Marketing Platform"
- Headline: "Where Brands Meet **Creators**" — "Creators" in gradient text (purple)
- Subtitle: "Connect with top content creators, launch campaigns, and grow your brand through authentic partnerships."
- Dual CTA: lime button "Get Started Free" + dark button "Browse Campaigns"
- Below content: CSS-built product mockup (campaign card UI) overlapping below hero by ~200px

### 3. Logo Strip
- "Trusted by brands across" + horizontal row of category pills
- Categories: Fashion, Tech, Food, Travel, Beauty, Fitness
- Pills: soft bg, rounded-full, small text

### 4. How It Works
- Dark background (`#101613`)
- Eyebrow: "HOW IT WORKS"
- Headline: white text "Three steps to **authentic** marketing" — "authentic" in lime
- 3-column grid, numbered steps:
  1. Brand posts campaign (icon: megaphone)
  2. Creators apply (icon: users)
  3. Collaborate & grow (icon: trending-up)
- Each step: number badge (lime bg), icon, title, description
- Columns have thin border separators

### 5. Features
- White background
- Eyebrow: "FEATURES"
- Headline: "Everything you need to **scale**" — "scale" in gradient purple
- Bento grid (2-column asymmetric):
  - Large left card (span 2 rows): Campaign Marketplace — browse/filter campaigns by category, budget, deadline
  - Top-right card: Smart Messaging — built-in conversation thread between brand and creator
  - Bottom-right card: Reviews & Ratings — trust-building review system with star ratings
- Cards: `var(--soft)` bg, `border-radius: 24px`, subtle border, hover lift

### 6. For Creators / For Brands
- Soft background
- Headline: "Built for **both** sides" — "both" in purple
- Two-column layout:
  - Left "For Creators": find campaigns, set your rate, build portfolio, get paid
  - Right "For Brands": post campaigns, review applications, track results, build relationships
- Each column: icon list with checkmarks

### 7. Testimonials
- White background
- Eyebrow: "TESTIMONIALS"
- Headline: "Loved by **creators** and brands" — "creators" in lime
- 3-column card grid:
  - Card 1: Creator testimonial (purple quote mark)
  - Card 2: Brand testimonial
  - Card 3: Creator testimonial
- Each card: quote text, avatar initial circle, name, role

### 8. CTA
- Dark background with blurred lime + purple orb effects
- Headline: "Ready to **connect**?" — "connect" in gradient
- Subtitle: "Join hundreds of brands and creators already growing together on Brand Connect."
- Dual CTA: lime button + ghost/outline button

### 9. Footer
- Dark background (`#0e1310`)
- 4-column grid:
  - Brand Connect (logo + tagline)
  - Product (Browse Campaigns, For Creators, For Brands, Pricing)
  - Company (About, Blog, Careers, Contact)
  - Legal (Privacy, Terms, Cookie Policy)
- Bottom bar: copyright + social icons

## Animations

- Reveal on scroll: `translateY(18px)` to `0`, `opacity: 0` to `1`, `0.65s ease-out`
- Staggered delays: `0.08s`, `0.16s`, `0.24s`
- Button hover: `translateY(-2px)`, `0.2s ease`
- Card hover: `translateY(-3px)` with shadow
- Smooth scroll on html
- Reduced motion: kill all animations

## Responsive

- `1050px`: sidebar collapse, hero shrinks
- `820px`: hamburger nav, single-column layouts
- `560px`: full mobile, stacked CTAs, smaller type

## Route Changes

- Modify `GET /` route in `routes/web.php` to render `welcome` view instead of redirect
- Keep existing `/dashboard` route for authenticated users
