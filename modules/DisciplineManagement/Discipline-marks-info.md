# AI Agent Prompt — Student Discipline Marks Matrix Module

Copy everything in the section below into your Claude Code / AI coding agent as the task prompt. The plan above it is for your own r eference.

---

## 1. Plan Summary (for you, Yohan)

**Goal:** Add a new "Student Discipline Marks Matrix" module to the school ERP, following the existing Laravel backend + React Native frontend architecture used across the rest of school-app.toyar.lk.

**Core mechanics extracted from your document:**

- Every student starts each **academic year** (Sep 1 → Aug 31 next year) with **100 discipline marks**.
- Marks are cumulative through the year; each approved misconduct record deducts marks based on a 5-level matrix.
- Marks reset to 100 automatically at the start of the next academic year — but history from prior years must stay queryable (not overwritten).
- Misconduct is classified via a master matrix table (Level 1–5), each with a nature/description and an indicative deduction range.
- Each individual incident is a separate record tied to a student, a misconduct level, an offence, a description, marks deducted, who reported/approved it, and whether the parent was informed.
- Frontend needs: student search (by name or admission no.), a per-student discipline profile (remaining % + history table), and a grade-filtered discipline chart/dashboard for staff.

**Two backend entities you need:**

1. `discipline_misconduct_levels` — the master matrix (Level 1–5 config, admin-managed, rarely changes).
2. `discipline_records` (or `discipline_incidents`) — one row per actual incident tied to a student + academic year.

Plus a derived/computed value: **remaining marks = 100 − SUM(approved deductions for that student for the current academic year)**. Don't store "remaining marks" as a static writable field — compute it (or cache it with a recalculation trigger) so corrections/edits never desync it.

**Conduct rating bands from your doc** (worth building in as a lookup, used for termly/annual reporting):
| Remaining Marks | Rating |
|---|---|
| 95–100 | Outstanding Conduct |
| 90–94 | Very Good Conduct |
| 80–89 | Good Conduct |
| 70–79 | Satisfactory Conduct |
| 60–69 | Improvement Required |
| Below 60 | Serious Improvement Required |

**Approval workflow implied by the doc (Section 6):**

- Level 1 → can be recorded directly by a Teacher/Class Teacher.
- Level 2 → reviewed by Class Teacher/Sectional Head.
- Level 3–5 → must go through the Disciplinary Management Committee/Management before the deduction is finalized.
- So records need a `status` (pending / approved / rejected) and only **approved** records should count toward the remaining-marks calculation. This matches your note: "College App shall display only deductions that have completed the required review and approval process."

I've put all of this — plus every misconduct-level row and every incident-record field from your document — directly into the agent prompt below, so your coding agent doesn't have to guess the values.

---

## 2. The Prompt (paste this to your AI coding agent)

```
ROLE
You are working inside our existing multi-tenant School ERP codebase
(Laravel backend, React Native frontend, multi-tenant architecture with
roles: parents, students, educators, school management, administrators).

TASK
Build a new "Student Discipline Marks Matrix" module — a backend Laravel
module + a React Native frontend section — that lets authorized staff
record student misconduct, automatically track each student's remaining
discipline marks for the current academic year, and let staff browse
students' discipline history and grade-level discipline charts.

Before writing any code, first explore the existing codebase to learn
and REUSE our established conventions for:
- how existing modules are structured (folder layout, naming, service
  layer usage, repository pattern if any)
- how student data is currently loaded/searched from backend to
  frontend (there is already a "select student" flow elsewhere in the
  app — study and reuse it rather than rebuilding it)
- how multi-tenancy is scoped on every query (tenant_id / school_id
  pattern)
- how roles/permissions and route middleware are enforced
- how migrations, API resources, form requests, and validation are
  written in this codebase
- how academic years are represented elsewhere in the app, if at all

Then implement to this spec:

====================================================================
DOMAIN RULES
====================================================================
1. Academic year definition: Sep 1 → Aug 31 of the following year
   (e.g. 2025-09-01 to 2026-08-31 = "2025-2026"). Every discipline
   calculation is scoped to one academic year.
2. Every student is allocated 100 discipline marks at the start of
   each academic year. This is not a stored mutable field — it is a
   constant baseline.
3. Remaining marks for a student in a given academic year =
     100 - SUM(marks_deducted from all APPROVED discipline records
              for that student in that academic year)
   Never let remaining marks go below 0 (floor at 0). Compute this
   value on read (or cache it with a recalculation hook fired on
   create/update/delete/approve of a discipline record) — do not
   store it as an independently-editable field, to avoid drift.
4. Marks from a prior academic year must remain permanently visible
   in that student's history; they do NOT roll over or reduce the
   new year's 100. Each academic year is its own bucket.
5. Only records with status = "approved" count toward the remaining
   marks calculation and toward what's visible to parents/students.
   Pending and rejected records are visible to staff only.

====================================================================
ENTITY 1 — Misconduct Level Matrix (master/config data, admin-managed)
====================================================================
Table: discipline_misconduct_levels
Fields: id, tenant/school scope (per existing convention), level_number
(1-5), level_name, nature_of_offence (text), indicative_deduction_min
(int), indicative_deduction_max (int), examples (text, comma or
newline separated), is_active, timestamps.

Seed this table with the following exact data (from the school's
official Student Discipline Marks Matrix document — do not alter
these values):

Level 1 - Minor Misconduct
  Nature: Minor breach of College rules with limited impact
  Deduction range: 1-3 marks
  Examples: Late arrival, incomplete homework, improper uniform,
  unnecessary talking, failure to bring books/stationery, minor
  classroom disruption

Level 2 - Repeated Minor Misconduct
  Nature: Repeated minor offences or behaviour continuing after warning
  Deduction range: 4-7 marks
  Examples: Repeated lateness, repeated uniform violations, repeated
  classroom disruption, misuse of electronic devices

Level 3 - Moderate Misconduct
  Nature: More significant misconduct affecting discipline, learning
  or College operations
  Deduction range: 8-15 marks
  Examples: Disrespect towards staff, leaving class without
  permission, inappropriate language, repeated misconduct, minor
  vandalism

Level 4 - Serious Misconduct
  Nature: Serious breach affecting safety, rights, academic
  integrity, property or College reputation
  Deduction range: 16-30 marks
  Examples: Bullying, cyberbullying, fighting, theft, examination
  malpractice, forgery, serious misuse of social media, vandalism

Level 5 - Gross Misconduct
  Nature: Extremely serious misconduct involving major safety,
  legal, ethical or institutional concerns
  Deduction range: 31-50 marks
  Examples: Weapons, illegal drugs, alcohol, serious assault, sexual
  harassment, criminal conduct or behaviour seriously endangering
  others

Build simple admin CRUD for this table (Management role only) so the
levels/deductions can be edited in future years without a code change.

====================================================================
ENTITY 2 — Discipline Record (one row per incident)
====================================================================
Table: discipline_records
Fields (map directly to the "Required Record" fields from the
school's official form):
- id
- tenant/school scope (per existing convention)
- student_id (FK to existing students table)
- academic_year (derived/stored as e.g. "2025-2026", or FK to an
  academic_years table if one already exists in this codebase — check
  first)
- misconduct_level_id (FK to discipline_misconduct_levels)
- offence (short text — the specific offence name, e.g. "Fighting")
- description (text — brief description of the incident)
- incident_date (date)
- marks_deducted (int — must fall within the selected level's
  indicative_deduction_min/max range; allow override by
  authorized approver with a reason if outside range)
- disciplinary_action_taken (text, nullable)
- reported_by (FK to staff/user)
- reviewed_by (FK to staff/user, nullable until approved)
- status (enum: pending, approved, rejected)
- parent_informed (boolean)
- student_response (text, nullable)
- grade_class_at_time (string — snapshot of student's grade/class
  when the incident was recorded, since students move up grades)
- timestamps

====================================================================
APPROVAL WORKFLOW
====================================================================
Implement level-based routing on create:
- Level 1 records: auto-status "approved" when created by a
  Teacher/Class Teacher (or route to their supervisor if you want a
  stricter default — confirm with existing permission tiers).
- Level 2 records: status "pending" until reviewed/approved by
  Class Teacher/Sectional Head or higher.
- Level 3-5 records: status "pending" until reviewed/approved by
  Management/Disciplinary Committee role.
Only update reviewed_by + status via an explicit "approve/reject"
endpoint, never via the general update endpoint, so there's always an
audit trail of who approved what.

====================================================================
BACKEND — API ENDPOINTS TO BUILD
====================================================================
- GET  /api/discipline/misconduct-levels          (list matrix, for
       the frontend to populate the level/offence picker)
- CRUD /api/discipline/misconduct-levels/*         (admin only)
- GET  /api/students/search?q=&type=name|admission_no
       (reuse the EXISTING student search/load endpoint used
       elsewhere in the app if one exists — do not duplicate it)
- GET  /api/discipline/students/{student}/summary
       (returns: remaining marks, conduct rating band, academic year,
       full record history table for that student)
- GET  /api/discipline/records?grade=&academic_year=&status=
       (grade-filtered dashboard/chart data for staff)
- POST /api/discipline/records                    (create incident)
- PUT  /api/discipline/records/{record}           (edit — only while
       pending, or per existing edit-permission conventions)
- POST /api/discipline/records/{record}/approve
- POST /api/discipline/records/{record}/reject
- DELETE /api/discipline/records/{record}          (soft delete,
       management only, with reason logged if this codebase has an
       audit-log convention — reuse it)

Apply the same tenant scoping, auth guards, and role permission
middleware used by other modules in this codebase. Validate
marks_deducted server-side against the selected level's range
(reject or flag out-of-range values per the rule above).

Add the conduct rating band as a small helper/service function,
reusable anywhere remaining marks are shown:
  95-100 -> Outstanding Conduct
  90-94  -> Very Good Conduct
  80-89  -> Good Conduct
  70-79  -> Satisfactory Conduct
  60-69  -> Improvement Required
  below 60 -> Serious Improvement Required

====================================================================
FRONTEND — SCREENS TO BUILD (React Native, match existing UI patterns)
====================================================================
1. Student Search / Select screen
   - Reuse the existing "load students from backend, select a
     student" flow already used elsewhere in the app.
   - Search must work by student name AND admission number.
   - Add a grade/class filter.

2. Student Discipline Profile screen (after selecting a student)
   - Header: student name, admission no, grade/class, current
     academic year.
   - Prominent remaining-marks display (e.g. "82 / 100") plus the
     conduct rating band.
   - Table/list of that student's discipline_records for the current
     academic year (offence, level, date, marks deducted, status).
   - Toggle or tab to view previous academic years' history.
   - "Add Discipline Issue" button (permission-gated) opens the
     add-record form.

3. Add Discipline Record form
   - Select Misconduct Level (1-5) -> auto-populate Nature of
     Offence + suggested deduction range + examples from the matrix,
     to guide the staff member.
   - Fields: offence, description, incident date, marks deducted
     (pre-filled with suggested value, editable within range),
     disciplinary action taken, parent informed (yes/no), student
     response (optional).
   - On submit, route to pending/approved per the level-based
     workflow above; show the resulting status to the user.

4. Grade-level Discipline Dashboard/Chart (staff view)
   - Filter by grade/class and academic year.
   - Chart/summary of remaining marks distribution or conduct rating
     bands across the filtered students, plus a drill-down list.

====================================================================
NON-NEGOTIABLE CONSTRAINTS
====================================================================
- Match this codebase's existing folder structure, naming
  conventions, and code style exactly — do not introduce a new
  architectural pattern for this module.
- Reuse the existing student-loading/search mechanism rather than
  building a second one.
- Every query must be scoped to the correct tenant/school per this
  codebase's existing multi-tenancy pattern.
- Do not store "remaining marks" as an independently-writable field —
  compute or cache-with-recalculation only.
- Preserve full historical records per academic year; never overwrite
  or delete on year rollover.
- Every discipline record write must be traceable to a
  reported_by/reviewed_by user for audit purposes.

DELIVERABLES
1. Migrations for both tables (+ academic_years table only if one
   does not already exist in this codebase — check first).
2. Models with relationships, and a seeder for the misconduct-level
   matrix using the exact data above.
3. Form requests / validation.
4. Controllers + API resources for all endpoints listed above.
5. A DisciplineMarksService (or equivalent per this codebase's
   service-layer convention) that owns the remaining-marks
   calculation and the conduct-rating-band lookup, so both backend
   and any reporting code call one source of truth.
6. React Native screens listed above, wired to the new endpoints and
   reusing existing shared components (buttons, tables, search
   inputs, filters) already in the codebase.
7. A short README note in the module describing the academic-year
   reset behavior, so future devs don't "fix" it into rolling over
   marks incorrectly.

Before starting, summarize back to me: (a) where in the existing
codebase you found the student search/load flow you'll reuse, (b)
whether an academic_years table already exists, and (c) your proposed
folder/file layout for this module — so I can confirm before you
generate code.
```

---

A couple of things worth deciding before you hand this off, since the source document leaves them open:

- **Level 1 auto-approval** — your doc says Level 1 "may be recorded" by a teacher, which reads as looser than Level 2's "shall be reviewed." I defaulted it to auto-approved in the prompt; tell the agent to route it through a supervisor instead if you'd rather every record pass through one review step regardless of level.
- **Out-of-range deductions** — the doc explicitly says the deduction can vary by circumstance, so I built in an override-with-reason rather than a hard block. If you want a hard validation ceiling instead, say so up front.
