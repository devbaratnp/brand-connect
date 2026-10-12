---
name: Brand Connect
description: Where Brands Meet Creators — Two-sided influencer marketplace
colors:
  primary: "#c9ff55"
  primary-strong: "#a8ed2e"
  secondary: "#7c5cff"
  secondary-deep: "#5b3df5"
  ink: "#161c18"
  muted: "#667069"
  soft: "#f5f7f5"
  paper: "#ffffff"
  dark: "#101613"
  dark-deep: "#0e1310"
  line: "#e4e9e5"
typography:
  display:
    fontFamily: "Instrument Sans, ui-sans-serif, system-ui, sans-serif"
    fontSize: "clamp(1.75rem, 3vw, 2.25rem)"
    fontWeight: 800
    lineHeight: 1.15
    letterSpacing: "-0.05em"
  headline:
    fontFamily: "Instrument Sans, ui-sans-serif, system-ui, sans-serif"
    fontSize: "clamp(1.25rem, 2vw, 1.5rem)"
    fontWeight: 750
    lineHeight: 1.2
    letterSpacing: "-0.03em"
  title:
    fontFamily: "Instrument Sans, ui-sans-serif, system-ui, sans-serif"
    fontSize: "0.875rem"
    fontWeight: 700
    lineHeight: 1.4
  body:
    fontFamily: "Instrument Sans, ui-sans-serif, system-ui, sans-serif"
    fontSize: "0.875rem"
    fontWeight: 400
    lineHeight: 1.5
  label:
    fontFamily: "Instrument Sans, ui-sans-serif, system-ui, sans-serif"
    fontSize: "0.75rem"
    fontWeight: 700
    lineHeight: 1.3
    letterSpacing: "0.06em"
    textTransform: "uppercase"
rounded:
  sm: "6px"
  md: "10px"
  lg: "14px"
  xl: "16px"
spacing:
  xs: "4px"
  sm: "8px"
  md: "16px"
  lg: "20px"
  xl: "28px"
  page: "32px"
components:
  button-primary:
    backgroundColor: "{colors.primary}"
    textColor: "{colors.ink}"
    rounded: "{rounded.md}"
    padding: "9px 18px"
    size: "40px"
  button-primary-hover:
    backgroundColor: "{colors.primary-strong}"
    textColor: "{colors.ink}"
  button-dark:
    backgroundColor: "{colors.ink}"
    textColor: "{colors.paper}"
    rounded: "{rounded.md}"
    padding: "9px 18px"
  button-ghost:
    backgroundColor: "transparent"
    textColor: "{colors.ink}"
    rounded: "{rounded.md}"
    border: "1px solid {colors.line}"
    padding: "9px 18px"
  button-sm:
    size: "34px"
    padding: "6px 14px"
    rounded: "{rounded.sm}"
  card:
    backgroundColor: "{colors.paper}"
    textColor: "{colors.ink}"
    rounded: "{rounded.xl}"
    padding: "{spacing.xl}"
  input:
    backgroundColor: "{colors.paper}"
    textColor: "{colors.ink}"
    rounded: "{rounded.md}"
    border: "1px solid {colors.line}"
    padding: "10px 14px"
  stat:
    backgroundColor: "{colors.paper}"
    rounded: "{rounded.lg}"
    padding: "22px"
  badge:
    rounded: "{rounded.sm}"
    padding: "4px 10px"
  nav:
    backgroundColor: "rgba(255,255,255,0.86)"
    textColor: "{colors.muted}"
    rounded: "{rounded.md}"
---

# Design System: Brand Connect

## 1. Overview

**Creative North Star: "The Creator's Command Center"**

Clean, energetic, and purposeful. Brand Connect's app UI is a professional workspace where creators manage their partnership pipeline. The design is confident but never loud — lime energy meets dark structure, with generous whitespace and purposeful hierarchy. Every element earns its place: no decorative flourishes, no glassmorphism, no generic SaaS tropes.

The system explicitly rejects over-designed patterns. There are no heavy gradients, no side-stripe borders, no numbered section markers. Cards are flat with subtle borders — shadows only appear on interactive states (button hover, card hover). The visual rhythm comes from the lime/purple accent contrast and tight typography, not from decorative surfaces.

**Key Characteristics:**
- Functional and clean — every pixel earns its place
- Lime + purple dual accent system for energy without clutter
- Tight editorial typography: 750–800 weight, negative letter-spacing on headings
- Flat surfaces with subtle borders, shadows only on interaction
- Generous card radii (16px) and spacing (28px padding) for breathing room

## 2. Colors

The palette is anchored by a high-energy lime accent against deep ink neutrals, with purple as a deliberate secondary voice for interactive signals and highlights.

### Primary
- **Lime** (`#c9ff55` / oklch(89% 0.16 120)): Primary action color. Used for brand accent, primary buttons, and energetic highlights. Its rarity is the point — ≤10% of any given screen.
- **Lime Strong** (`#a8ed2e` / oklch(82% 0.18 115)): Button hover state for the primary action. Slightly deeper for contrast.

### Secondary
- **Purple** (`#7c5cff` / oklch(63% 0.18 282)): Secondary accent. Used for input focus rings, role card selection, empty state links, and gradient text on the marketing landing page. Signals interactivity without competing with lime.
- **Purple Deep** (`#5b3df5` / oklch(55% 0.18 282)): Purple emphasis state.

### Neutral
- **Ink** (`#161c18` / oklch(20% 0.015 160)): Primary text and dark surfaces. Near-black with a slight green undertone for warmth.
- **Muted** (`#667069` / oklch(48% 0.02 160)): Secondary text, labels, metadata. Meets WCAG AA 4.5:1 on white.
- **Soft** (`#f5f7f5` / oklch(96% 0.005 160)): Page background, table header background. Near-white with the slightest green cast.
- **Paper** (`#ffffff`): Card and container backgrounds. True white provides crisp contrast with the tinted page bg.
- **Dark** (`#101613` / oklch(18% 0.015 160)): Dark section backgrounds. Used on the landing page's dark sections.
- **Dark Deep** (`#0e1310` / oklch(16% 0.015 160)): Footer background.
- **Line** (`#e4e9e5` / oklch(89% 0.01 160)): Borders and dividers. Subtle, never competing with content.

### Named Rules
**The Rarity Rule.** The lime primary accent covers ≤10% of any given screen. Its restraint is what makes it hit. Overused lime reads as gaudy; reserved lime reads as energetic confidence.

**The Flat-By-Default Rule.** Surfaces are flat at rest — no shadows, no gradients. Depth is communicated through borders (`--line`) and typographic hierarchy, not through elevation. Shadows appear only as a response to interaction (hover, focus).

## 3. Typography

**Display Font:** Instrument Sans (800 weight)
**Body Font:** Instrument Sans (400 weight)
**Label Font:** Instrument Sans (700 weight, uppercase, tracked)

**Character:** A single-family approach — Instrument Sans carries the entire system. The contrast comes from extreme weight shifts (400 body → 800 display) and tight negative letter-spacing on headings. The result is editorial and confident without needing a second typeface.

### Hierarchy
- **Display** (800, `clamp(1.75rem, 3vw, 2.25rem)`, 1.15): Page titles and hero headings. Tight letter-spacing `-0.05em`. Used for `bc-page-title`.
- **Headline** (750, `clamp(1.25rem, 2vw, 1.5rem)`, 1.2): Card titles and section headings. Moderate negative spacing `-0.03em`. Used for `bc-card-title`.
- **Title** (700, `0.875rem`, 1.4): List item titles, stat values, strong inline text. Used for `bc-stat-value`, `bc-list-item-title`.
- **Body** (400, `0.875rem`, 1.5): Paragraphs, table cells, list item subtitles. Max line length 65–75ch. Used for `bc-list-item-sub`, `bc-stat-sub`.
- **Label** (700, `0.75rem`, 1.3): Table headers, badge text, metadata. Uppercase with `0.06em` letter-spacing. Used for `bc-table th`, `bc-stat-label`.

### Named Rules
**The Weight Contrast Rule.** Body text is always 400 weight. Headings are 750–800. There is no 500 or 600 weight body text — the jump from 400 to 750+ is intentional and structural.

## 4. Elevation

The system is flat by default. Depth comes from tonal layering (ink text on soft page bg on paper cards), not from shadows. Borders (`--line`) separate surfaces. Shadows are used sparingly and only for interactive feedback:
- **Button hover**: a 2px translateY lift, no shadow on the button itself
- **Card hover**: `0 8px 30px rgba(0,0,0,0.04)` — a whisper shadow, not a float
- **Dropdown menu**: `0 12px 40px rgba(0,0,0,0.1)` — the highest elevation in the system, reserved for overlay panels

Ambient shadows do not exist. No surface has a resting shadow.

## 5. Components

### Buttons
- **Shape:** Generous rounded corners (10px default `--radius-md`, 8px for small, 12px for large)
- **Primary:** Lime background (`#c9ff55`), ink text, 9px 18px padding, 40px height. Hover shifts to lime-strong (`#a8ed2e`) with 1px translateY lift. Box shadow on primary only: `0 2px 12px rgba(163,220,47,0.2)`.
- **Dark:** Ink background, white text. Functional, not decorative.
- **Ghost:** Transparent with a 1px `--line` border. Hover adds a subtle black 3% background tint.
- **Small variant (bc-btn-sm):** 34px height, 6px 14px padding, 8px radius. For inline and compact contexts.
- **All buttons:** `transition: all .2s`, `font-weight: 650`, no outline on default state.

### Cards / Containers
- **Corner Style:** Generous 16px radius
- **Background:** White (`--paper`)
- **Border:** 1px solid `--line`
- **Shadow Strategy:** Hover-only whisper shadow (`0 8px 30px rgba(0,0,0,0.04)`)
- **Internal Padding:** 28px (`--spacing-xl`)

### Stats
- **Corner Style:** 14px radius
- **Background:** White (`--paper`)
- **Border:** 1px solid `--line` plus a 3px left border accent (lime, purple, or ink to distinguish stat groups)

### Inputs / Fields
- **Style:** 1px `--line` border, white background, 10px radius
- **Focus:** Purple border with `0 0 0 3px rgba(124,92,255,0.12)` ring
- **Error:** Red border (`#f87171`) with matching error ring
- **Disabled / readonly:** Inherit base style; use placeholder for contextual cues

### Badges
- **Style:** 6px radius, 4px 10px padding, 12px font, 700 weight
- **Color by meaning:** Green for open/accepted/active/creator, amber for pending, purple for progress/brand, red for rejected/admin, gray for closed/inactive

### Navigation
- **Style:** Sticky top bar (72px), glassmorphic (rgba white 86% + 18px blur), bottom border `--line` at 60% opacity
- **Typography:** 600 weight, 14px, muted color default → ink on hover/active
- **Mobile:** Links collapse behind a hamburger toggle at ≤820px

### Chat / Messages
- **Sent messages:** Ink background, white text, 16px radius with 4px bottom-right corner
- **Received messages:** White background, `--line` border, 16px radius with 4px bottom-left corner
- **Max width:** 70% of container

## 6. Do's and Don'ts

### Do:
- **Do** use lime sparingly — ≤10% of surface area. Let it be the accent that draws attention.
- **Do** use the full 750–800 weight range for all headings. Body stays at 400.
- **Do** keep surfaces flat at rest. Use borders (`--line`) for separation, not shadows.
- **Do** use the purple focus ring (`rgba(124,92,255,0.12)`) on all interactive elements.
- **Do** prefer card layouts with generous padding (28px) and radii (16px) — let the content breathe.
- **Do** use green/amber/red/purple badge colors semantically — they carry meaning, not decoration.

### Don't:
- **Don't** use side-stripe borders (colored `border-left` >1px as decoration). Use full borders or background tints instead.
- **Don't** use gradient text (`background-clip: text`). In the app UI, headings are solid ink.
- **Don't** use glassmorphism as a default. The nav is the only glass surface in the system.
- **Don't** use numbered section markers (01 / 02 / 03) as default scaffolding.
- **Don't** use tiny uppercase tracked eyebrow text above every section — one deliberate kicker is voice, repeating it across every section is AI grammar.
- **Don't** use shadows on resting surfaces. Shadows are for interactive feedback only.
- **Don't** over-decorate — no heavy gradients, no decorative flourishes, no generic SaaS dashboard tropes.
- **Don't** make body text lighter than `--muted` (`#667069`). Gray text for "elegance" is the top readability failure.
