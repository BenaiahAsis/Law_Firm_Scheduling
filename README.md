# Law Firm Client Portal & Scheduling System

A full-stack web application built to streamline legal consultations, document submissions, and client-lawyer communication. This system provides a secure, role-based environment for clients to request legal services and for administrators to manage caseloads efficiently.

**Developer:** Benaiah Asis  

---

## 🚀 Core Features

* **Role-Based Access Control (RBAC):** Distinct dashboards and routing protection for Clients and Law Firm Administrators.
* **Secure Document Management:** Clients can upload supporting case files (PDF, JPG, PNG). The system uses Laravel's local storage linking to securely serve these files exclusively to authorized administrators.
* **Event-Driven Email Notifications:** Automated status updates. When an admin changes a case status (e.g., from *Pending* to *Scheduled*), the system automatically compiles and queues an HTML email to the client.
* **Self-Service & Data Integrity:** Clients can cancel requests and delete records, but only if the status is "Pending." The system automatically purges the associated physical files from the server upon cancellation to optimize storage.
* **Dynamic Status Tracking:** Real-time visual updates on the client dashboard regarding their consultation status.

---

## 💻 Tech Stack

* **Backend:** PHP, Laravel (v11.x)
* **Frontend:** Blade Templating, Tailwind CSS, Alpine.js
* **Database:** MySQL
* **Version Control:** Git & GitHub

---

## ⚙️ Local Installation & Setup

If you want to run this project locally on your machine, follow these steps:

1. **Clone the repository:**
   ```bash
   git clone [https://github.com/BenaiahAsis/Law_Firm_Scheduling.git](https://github.com/BenaiahAsis/Law_Firm_Scheduling.git)
   cd Law_Firm_Scheduling