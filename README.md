# myReno: Home Decoration and Design Portal

This project, **myReno**, is a home decoration and design portal that connects clients and contractors in a centralized workspace. Users can register and log in as clients or contractors, with access to features specific to their roles.

Developed using Laravel and Vue.js

Includes real time messaging and chat function using Chatify

---

## Functional Requirements

### Module 1: Communication and Project Management

| Requirement ID | Description                                                                                         |
|----------------|-----------------------------------------------------------------------------------------------------|
| FR03           | The system should provide the users the ability to track and manage project progress.               |
| FR04           | The system should provide the users with the ability to search for designers.                       |
| FR05           | The system should provide the users with the ability to create, edit, and delete projects.          |
| FR06           | The system should provide the users with the means to communicate and transfer/share files for collaboration purposes. |
| FR07           | The system should provide the users with the ability to validate proof of payment.                  |

### Module 2: User Profiles

| Requirement ID | Description                                                                                         |
|----------------|-----------------------------------------------------------------------------------------------------|
| FR08           | The system should provide the users the ability to manage their user profile.                       |
| FR09           | The system should provide the users the ability to showcase their portfolio.                        |
| FR10           | The system should provide the users with the ability to leave reviews and feedback on other user profiles. |

### Module 3: Financial and Budget Tracking

| Requirement ID | Description                                                                                         |
|----------------|-----------------------------------------------------------------------------------------------------|
| FR11           | The system should provide the users the ability for financial and budget expenses tracking.         |
| FR12           | The system should be able to generate reports and invoices for users.                               |
| FR13           | The system should allow users to download and print reports and invoice documents.                  |
| FR14           | The system should provide the ability for users to view and assess financial records.               |

### Module 4: Administration

| Requirement ID | Description                                                                                         |
|----------------|-----------------------------------------------------------------------------------------------------|
| FR15           | The system should provide the ability for admins to manage users and assign permissions.            |
| FR16           | The system should provide the ability for admins to moderate the content in the system (delete contents). |
| FR17           | The system should provide the ability for admins to provide proper user support at an administrative level. |
| FR18           | The system should have proper and designated access control.                                        |

---

## Database Structure

### 1. Users
- **Username**: User's chosen name.
- **Email**: User's email address.
- **PasswordHash**: Hashed password for secure storage.
- **UserType**: Differentiates between designers, contractors, and regular users.
- **ProfileID**: FK to UserProfile table.

### 2. UserProfile
- **ProfileID (PK)**: Unique identifier for user profiles.
- **UserID (FK)**: Linked to Users table.
- **FullName**: User's full name.
- **Bio**: Short biography or description.
- **ProfilePic**: URL/path to profile picture.
- **PortfolioID**: FK to Portfolio table.

### 3. Portfolio
- **PortfolioID (PK)**: Unique identifier for portfolios.
- **ProfileID (FK)**: Linked to UserProfile table.
- **ProjectExamples**: Links or images of past work.
- **ReviewsID**: FK to Reviews table.

### 4. Reviews
- **ReviewID (PK)**: Unique identifier for reviews.
- **ReviewerID**: UserID of the reviewer (FK to Users table).
- **SubjectID**: UserID of the reviewee (FK to Users table).
- **Rating**: Numerical rating.
- **Comment**: Textual feedback.

### 5. Projects
- **ProjectID (PK)**: Unique identifier for projects.
- **OwnerID (FK)**: UserID of the project owner.
- **Name**: Project name.
- **Description**: Detailed description of the project.
- **Status**: Current status of the project (e.g., In Progress, Completed).
- **StartDate**: Project start date.
- **EndDate**: Project end date.

### 6. ProjectCollaborators
- **CollaborationID (PK)**: Unique identifier for each collaboration.
- **ProjectID (FK)**: Linked to Projects table.
- **UserID (FK)**: Linked to Users table.
- **Role**: The role of the user in the project (e.g., Designer, Contractor).

### 7. Files
- **FileID (PK)**: Unique identifier for files.
- **ProjectID (FK)**: Linked to Projects table.
- **UploaderID (FK)**: UserID of the uploader.
- **FilePath**: URL/path to the file.
- **UploadDate**: Date of upload.

### 8. Financial Records
- **RecordID (PK)**: Unique identifier for financial records.
- **ProjectID (FK)**: Linked to Projects table.
- **UserID (FK)**: Linked to Users table indicating who made the transaction.
- **Amount**: Amount of the transaction.
- **Type**: Type of transaction (e.g., Invoice, Payment).
- **Date**: Date of the transaction.

### 9. Admins
- **AdminID (PK)**: Unique identifier for administrators.
- **UserID (FK)**: Linked to Users table.

### 10. Permissions
- **PermissionID (PK)**: Unique identifier for permissions.
- **AdminID (FK)**: Linked to Admins table.
- **PermissionType**: Type of permission granted.

---

