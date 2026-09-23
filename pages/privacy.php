<?php
$seo = [
    'title' => 'Privacy Policy | Okie Heating & Cooling',
    'description' => 'How Okie Heating and Cooling collects, uses, discloses, retains, and protects personal information through okieheatingandcooling.com.',
    'path' => '/privacy',
];
$lastUpdated = 'September 23, 2026';
require SITE_ROOT . '/includes/layout/header.php';
?>
<section class="page-hero">
  <div class="container reveal">
    <h1 class="h1">Privacy Policy</h1>
    <p class="page-hero-sub">Effective Date: <?= e($lastUpdated) ?> &middot; Last Updated: <?= e($lastUpdated) ?></p>
  </div>
</section>

<section class="section">
  <div class="container-md legal-content reveal">
    <p class="legal-draft-notice"><strong>DRAFT — attorney-prepared, pending owner confirmation and final legal review before publication.</strong> Items in <strong>[BRACKETS]</strong> below require owner confirmation before this policy goes live. Sections marked <strong>[IF&nbsp;&hellip;]</strong> must be kept or deleted once that's confirmed. The practices this policy describes (retention, consent records with timestamp/IP/wording, Global Privacy Control handling, analytics URL redaction) are now implemented in code and match what's written below.</p>

    <h2>1. Introduction and Scope</h2>
    <p><strong>1.1</strong> This Privacy Policy (the &ldquo;Policy&rdquo;) describes how Okie Heating and Cooling (&ldquo;Okie,&rdquo; &ldquo;we,&rdquo; &ldquo;us,&rdquo; or &ldquo;our&rdquo;), a heating, ventilation, and air conditioning service provider based in Tulsa, Oklahoma, collects, uses, discloses, retains, and protects Personal Information in connection with the website located at <strong>https://okieheatingandcooling.com</strong>, including all of its pages, forms, and features (collectively, the &ldquo;Site&rdquo;).</p>
    <p><strong>1.2</strong> This Policy applies only to information collected through the Site and through communications arising from a request submitted on the Site. It does not apply to information collected offline, in person at a service location, by telephone independent of the Site, or through any third-party website, application, or service, even if linked from the Site.</p>
    <p><strong>1.3</strong> By accessing or using the Site, or by submitting information through it, you acknowledge that you have read and understood this Policy. If you do not agree with this Policy, please do not use the Site or submit information through it. You may instead contact us by telephone at <strong><?= e(OFFICE_PHONE_NUMBER) ?></strong>.</p>

    <h2>2. Definitions</h2>
    <p>For purposes of this Policy:</p>
    <ul>
      <li><strong>&ldquo;Personal Information&rdquo;</strong> means information that identifies, relates to, describes, or is reasonably capable of being associated with a particular individual or household, directly or indirectly.</li>
      <li><strong>&ldquo;Service Request&rdquo;</strong> means any submission made through a form on the Site, including requests for service, quotes, estimates, general inquiries, and maintenance-plan enrollment inquiries.</li>
      <li><strong>&ldquo;Service Provider&rdquo;</strong> means a third party that processes Personal Information on our behalf, under our instructions, for the purposes described in this Policy.</li>
      <li><strong>&ldquo;Device Data&rdquo;</strong> means technical information automatically transmitted by your browser or device, such as Internet Protocol (&ldquo;IP&rdquo;) address, browser type and version, operating system, device type, language settings, referring URL, and the date and time of access.</li>
      <li><strong>&ldquo;Sell,&rdquo; &ldquo;Share,&rdquo;</strong> and <strong>&ldquo;Targeted Advertising&rdquo;</strong> have the meanings given to them under applicable state privacy laws.</li>
    </ul>

    <h2>3. Personal Information We Collect</h2>
    <h3>3.1 Information You Provide Directly</h3>
    <p>When you submit a Service Request, we collect the information you choose to provide, which may include:</p>
    <table>
      <thead><tr><th>Category</th><th>Specific Data Elements</th><th>Required?</th></tr></thead>
      <tbody>
        <tr><td>Identifiers and contact information</td><td>Full name; telephone number; email address</td><td>Name and telephone number are required; email is optional</td></tr>
        <tr><td>Service location</td><td>Service street address; city</td><td>Optional</td></tr>
        <tr><td>Service details</td><td>Type of service requested; urgency level; whether you are a new or returning customer; preferred service date and time window; a free-text description of your issue</td><td>Service type is required; all others are optional</td></tr>
        <tr><td>Communications consent</td><td>Whether you checked the box consenting to calls and text messages</td><td>Optional</td></tr>
      </tbody>
    </table>
    <p>Please do not include sensitive information (such as financial account numbers, government identification numbers, or health information) in the free-text description field. <strong>We do not collect payment card or bank account information through the Site.</strong></p>

    <h3>3.2 Information Collected Automatically</h3>
    <p>When you visit the Site, we and our Service Providers automatically collect certain information:</p>
    <p>(a) <strong>Device Data</strong>, as defined above, collected by our hosting provider, our content delivery and security provider, and our analytics provider.</p>
    <p>(b) <strong>Usage and analytics data</strong>, including the pages you view, the time and duration of your visit, the links you click, the website that referred you, approximate geographic location (city or region) derived from your IP address, and whether you submitted a form. This information is collected through Google Analytics and through our own first-party measurement tool described in Section 8.</p>
    <p>(c) <strong>Marketing attribution data.</strong> If you arrive at the Site through a link containing campaign parameters (for example, &ldquo;utm_source,&rdquo; &ldquo;utm_medium,&rdquo; or &ldquo;utm_campaign&rdquo;), we record those parameters with any Service Request you submit so we can understand which advertising and outreach efforts are effective.</p>
    <p>(d) <strong>Submission metadata.</strong> When you submit a Service Request, we record the date and time of submission, the page from which it was submitted, your IP address, and your browser's user-agent string.</p>
    <p>(e) <strong>Security and anti-fraud data.</strong> Our forms use Cloudflare Turnstile, a bot-detection service that evaluates browser and device signals and your IP address to determine whether a submission is made by a human. We also use hidden spam-prevention fields and timing checks, and we temporarily record IP addresses to limit excessive submissions (see Section 10).</p>

    <h3>3.3 Information from Third Parties</h3>
    <p>We receive the result of the Cloudflare Turnstile verification (pass or fail) for each form submission. We do not purchase Personal Information from data brokers or obtain it from other third-party sources through the Site.</p>

    <h2>4. How We Use Personal Information</h2>
    <p>We use Personal Information for the following business purposes:</p>
    <p>(a) <strong>Service delivery:</strong> to respond to Service Requests; to prepare quotes and estimates; to schedule, confirm, dispatch, perform, and follow up on service appointments; and to administer maintenance plans.</p>
    <p>(b) <strong>Communications:</strong> to contact you by telephone, email, or (where you have consented) text message regarding your Service Request, appointment, or service, including confirmations, scheduling updates, and follow-up.</p>
    <p>(c) <strong>Confirmation emails:</strong> if you provide an email address, to send you an automated confirmation summarizing your Service Request.</p>
    <p>(d) <strong>Recordkeeping:</strong> to maintain records of Service Requests and the services we provide, including for warranty, accounting, tax, insurance, and licensing purposes.</p>
    <p>(e) <strong>Site operation and improvement:</strong> to operate, maintain, analyze, and improve the Site and understand how visitors use it.</p>
    <p>(f) <strong>Marketing measurement:</strong> to evaluate the effectiveness of our advertising and outreach. We do not use Site data for Targeted Advertising.</p>
    <p>(g) <strong>Security and fraud prevention:</strong> to detect, prevent, and respond to spam, fraud, abuse, security incidents, and other harmful or unlawful activity.</p>
    <p>(h) <strong>Legal compliance:</strong> to comply with applicable laws, regulations, legal process, and governmental requests, and to establish, exercise, or defend legal claims.</p>
    <p>We will not use Personal Information for purposes materially different from those described in this Policy without providing you notice and, where required by law, obtaining your consent.</p>

    <h2>5. Telephone Calls and Text Messages</h2>
    <p><strong>5.1 Consent.</strong> Our Service Request forms include an optional checkbox by which you may agree to receive calls and text messages from Okie Heating and Cooling at the telephone number you provide regarding your Service Request. <strong>Consent is not a condition of purchasing any goods or services.</strong> If you do not check the box, we may still contact you by telephone to respond to the request you initiated.</p>
    <p><strong>5.2 [IF TEXT MESSAGES ARE SENT] Text message terms.</strong> If you consent to text messages:</p>
    <ul>
      <li>Messages relate to your Service Request, appointment, and service (for example, scheduling, arrival, and follow-up). We do not send marketing text messages unless you separately agree to receive them.</li>
      <li>Message frequency varies based on your service needs.</li>
      <li>Message and data rates may apply according to your wireless carrier plan.</li>
      <li>Reply <strong>STOP</strong> at any time to stop receiving text messages. Reply <strong>HELP</strong> for assistance, or call <?= e(OFFICE_PHONE_NUMBER) ?>.</li>
      <li>Wireless carriers are not liable for delayed or undelivered messages.</li>
      <li>Text messages are sent [manually by our staff / through [NAME OF TEXTING OR CRM SOFTWARE]].</li>
    </ul>
    <p><strong>5.3 No sharing of mobile information.</strong> <strong>We do not sell, rent, or share your mobile telephone number or your text-messaging opt-in data or consent with any third party or affiliate for their marketing or promotional purposes.</strong> Mobile information may be disclosed to Service Providers that help us deliver messages to you, solely for that purpose.</p>
    <p><strong>5.4 Consent records.</strong> When you check the consent box, we record that you consented, the date and time, the wording of the consent statement displayed to you, and your IP address, so that we can demonstrate and honor your choice.</p>

    <h2>6. How We Disclose Personal Information</h2>
    <p><strong>6.1</strong> <strong>We do not Sell your Personal Information. We do not Share your Personal Information for cross-context behavioral advertising or Targeted Advertising.</strong> We have not done so in the preceding twelve (12) months.</p>
    <p><strong>6.2</strong> We disclose Personal Information only as follows:</p>
    <p>(a) <strong>Service Providers.</strong> We disclose Personal Information to Service Providers that perform services on our behalf, subject to contractual or legal obligations that limit their use of the information to providing services to us:</p>
    <table>
      <thead><tr><th>Service Provider</th><th>Function</th><th>Categories of Information</th></tr></thead>
      <tbody>
        <tr><td>Hostinger</td><td>Website hosting and data storage</td><td>All information collected through the Site</td></tr>
        <tr><td>Cloudflare, Inc.</td><td>Content delivery, network security, bot detection (Turnstile), and email-address obfuscation</td><td>Device Data; IP address; browser signals</td></tr>
        <tr><td>Google LLC (Google Analytics)</td><td>Website usage analytics</td><td>Device Data; usage data; approximate location; cookie identifiers</td></tr>
        <tr><td>[IF ACTIVE] Brevo (Sendinblue SAS)</td><td>Delivery of transactional emails</td><td>Name; email address; contents of Service Request confirmation and notification emails</td></tr>
        <tr><td>Khual Web Service LLC</td><td>Website development, maintenance, and technical support, including authorized access to submitted Service Requests through a secured interface</td><td>Service Request information (name, contact information, service location, service details, consent status)</td></tr>
        <tr><td>[NAME OF EMAIL HOSTING PROVIDER, e.g., Google Workspace]</td><td>Business email hosting (receipt of Service Request notifications)</td><td>Service Request information, including IP address, included in internal notification emails</td></tr>
        <tr><td>[NAME OF CRM / SCHEDULING / TEXTING SOFTWARE, IF ANY]</td><td>[Customer management / scheduling / text messaging]</td><td>[Categories]</td></tr>
      </tbody>
    </table>
    <p>(b) <strong>Legal requirements.</strong> We may disclose Personal Information if we believe in good faith that disclosure is necessary to comply with applicable law, regulation, subpoena, court order, or other legal process; to respond to lawful requests from public authorities; or to enforce our agreements.</p>
    <p>(c) <strong>Protection of rights and safety.</strong> We may disclose Personal Information where reasonably necessary to protect the rights, property, or safety of Okie, our customers, our employees, or others, including to prevent fraud or address security issues.</p>
    <p>(d) <strong>Business transfers.</strong> In connection with an actual or proposed merger, acquisition, financing, reorganization, sale of all or part of our business or assets, or similar transaction, Personal Information may be disclosed to or transferred to the counterparty, subject to this Policy or a policy providing substantially equivalent protection.</p>
    <p>(e) <strong>With your consent or at your direction.</strong> We may disclose Personal Information for any other purpose with your consent or at your direction.</p>

    <h2>7. Cookies and Similar Technologies</h2>
    <p><strong>7.1</strong> The Site and our Service Providers use cookies and similar technologies, including browser local storage, as described below:</p>
    <table>
      <thead><tr><th>Name</th><th>Provider</th><th>Type</th><th>Purpose</th><th>Duration</th></tr></thead>
      <tbody>
        <tr><td><code>_ga</code></td><td>Google Analytics</td><td>First-party cookie</td><td>Distinguishes unique visitors for analytics</td><td>Up to 2 years</td></tr>
        <tr><td><code>_ga_[ID]</code></td><td>Google Analytics</td><td>First-party cookie</td><td>Maintains session state for analytics</td><td>Up to 2 years</td></tr>
        <tr><td><code>__cf_bm</code></td><td>Cloudflare</td><td>Strictly necessary cookie</td><td>Distinguishes humans from bots to protect the Site</td><td>Approximately 30 minutes</td></tr>
        <tr><td><code>cf_clearance</code></td><td>Cloudflare</td><td>Strictly necessary cookie</td><td>Records that a security challenge was passed</td><td>Up to [DURATION PER CLOUDFLARE SETTINGS]</td></tr>
        <tr><td><code>okie_visitor_id</code></td><td>Okie (first-party)</td><td>Browser local storage</td><td>A random identifier used by our own measurement tool to count returning visitors</td><td>Until you clear your browser storage</td></tr>
        <tr><td><code>okie_session_id</code></td><td>Okie (first-party)</td><td>Browser session storage</td><td>A random identifier used to group page views within a single visit</td><td>Until you close the browser tab</td></tr>
      </tbody>
    </table>
    <p><strong>7.2</strong> The identifiers we set ourselves (<code>okie_visitor_id</code> and <code>okie_session_id</code>) are randomly generated, do not contain your name or contact information, and are sent only to our own servers. They are not shared with advertising networks.</p>
    <p><strong>7.3 Your choices.</strong> You may block or delete cookies and local storage through your browser settings. You may prevent Google Analytics from collecting your data by installing the Google Analytics Opt-out Browser Add-on, available at <a href="https://tools.google.com/dlpage/gaoptout" target="_blank" rel="noopener noreferrer">https://tools.google.com/dlpage/gaoptout</a>. Blocking strictly necessary Cloudflare cookies may prevent you from submitting forms. Blocking other cookies will not prevent you from using the Site or submitting a Service Request.</p>

    <h2>8. First-Party Measurement</h2>
    <p>In addition to Google Analytics, the Site uses its own measurement tool that records page views and certain interactions (such as the page visited, the referring page, the time of the event, and the random identifiers described in Section 7) on our own servers. This information is used solely to understand and improve Site performance and is not disclosed to third parties other than our hosting provider and website maintenance provider.</p>

    <h2>9. Browser Privacy Signals</h2>
    <p><strong>9.1 Global Privacy Control.</strong> The Site recognizes the Global Privacy Control (&ldquo;GPC&rdquo;) signal. If your browser transmits a GPC signal, we will not load Google Analytics or set Google Analytics cookies during your visit.</p>
    <p><strong>9.2 Do Not Track.</strong> Because there is no uniform industry standard for interpreting &ldquo;Do Not Track&rdquo; signals, the Site does not respond to them. We treat GPC as described above.</p>

    <h2>10. Data Retention</h2>
    <p><strong>10.1</strong> We retain Personal Information only for as long as reasonably necessary to fulfill the purposes described in this Policy, including to satisfy legal, accounting, tax, warranty, and reporting requirements, unless a longer retention period is required or permitted by law. Specifically:</p>
    <table>
      <thead><tr><th>Data</th><th>Retention Period</th></tr></thead>
      <tbody>
        <tr><td>Service Requests submitted through the Site</td><td>[Three (3)] years after the later of the submission date or your most recent service with us, then deleted or de-identified</td></tr>
        <tr><td>Consent records (calls and text messages)</td><td>For as long as the consent is in effect, and for [four (4)] years after it is revoked or expires, to document compliance</td></tr>
        <tr><td>First-party measurement data (site_events)</td><td>Fourteen (14) months, then deleted automatically</td></tr>
        <tr><td>Google Analytics data</td><td>[Fourteen (14)] months, per our Google Analytics data-retention setting</td></tr>
        <tr><td>Anti-abuse IP address records (form and login rate limiting)</td><td>Up to one (1) hour; automatically purged</td></tr>
        <tr><td>Server and security logs maintained by our hosting and network providers</td><td>According to those providers' standard retention practices</td></tr>
        <tr><td>Backups</td><td>[Retention per Hostinger backup settings], after which backups are overwritten</td></tr>
      </tbody>
    </table>
    <p><strong>10.2</strong> Where Personal Information is also part of customer records maintained outside the Site (for example, invoices or warranty records for work performed), those records are retained in accordance with our general business recordkeeping practices.</p>

    <h2>11. Data Security</h2>
    <p><strong>11.1</strong> We implement reasonable administrative, technical, and physical safeguards designed to protect Personal Information against unauthorized access, disclosure, alteration, and destruction. These measures include, among others: encryption of data in transit using HTTPS with HTTP Strict Transport Security; a restrictive Content Security Policy and other security headers; server-side bot verification that rejects unverified submissions; rate limiting of form submissions and administrative login attempts; restriction of stored data from public web access; password-protected administrative access; and token-based authentication for authorized maintenance access.</p>
    <p><strong>11.2</strong> No method of transmission over the internet or method of electronic storage is completely secure. While we strive to protect your Personal Information, we cannot guarantee its absolute security. You are responsible for the information you choose to transmit to us.</p>
    <p><strong>11.3</strong> In the event of a security incident affecting your Personal Information, we will notify you and any applicable authorities as required by applicable law, including the Oklahoma Security Breach Notification Act.</p>

    <h2>12. Location of Processing</h2>
    <p>We are located in the United States, and the Site is intended for users in the United States. Our Service Providers may process Personal Information in the United States and in other countries where they or their subprocessors maintain facilities, including, for example, Cloudflare's global network[, and, if Brevo is used, the European Union]. By using the Site, you understand that your information may be processed in countries whose data protection laws may differ from those of your state of residence.</p>

    <h2>13. Your Rights and Choices</h2>
    <p><strong>13.1 Rights available to you.</strong> Subject to applicable law, you may request that we:</p>
    <p>(a) confirm whether we process your Personal Information and provide you access to it;<br>
    (b) correct inaccurate Personal Information;<br>
    (c) delete Personal Information we hold about you;<br>
    (d) provide a copy of your Personal Information in a portable format; and<br>
    (e) stop contacting you by telephone, text message, or email.</p>
    <p><strong>13.2 Additional state-law rights.</strong> Depending on your state of residence, you may have additional rights under applicable state privacy law, including the right to opt out of the Sale of Personal Information, Targeted Advertising, or profiling. As stated in Section 6.1, we do not engage in those activities.</p>
    <p><strong>13.3 How to submit a request.</strong> To exercise any of these rights, contact us by email at <a href="mailto:<?= e(EMAIL) ?>"><?= e(EMAIL) ?></a> or by telephone at <strong><?= e(OFFICE_PHONE_NUMBER) ?></strong>. Please identify the right you wish to exercise and provide the name, telephone number, and email address used in your Service Request.</p>
    <p><strong>13.4 Verification.</strong> To protect your information, we will take reasonable steps to verify your identity before fulfilling a request, generally by matching information you provide with information in our records. We may decline a request if we cannot verify your identity.</p>
    <p><strong>13.5 Authorized agents.</strong> Where permitted by law, you may designate an authorized agent to submit a request on your behalf. We may require written proof of the agent's authority and may require you to verify your own identity directly with us.</p>
    <p><strong>13.6 Response timing.</strong> We will respond to verified requests within forty-five (45) days of receipt. Where reasonably necessary, we may extend this period by an additional forty-five (45) days and will inform you of the extension and the reason for it.</p>
    <p><strong>13.7 Exceptions.</strong> We may retain certain information notwithstanding a deletion request where retention is necessary to complete a transaction or service you requested, comply with a legal obligation, honor warranty obligations, detect security incidents or fraud, or establish, exercise, or defend legal claims. We will inform you of any such exception.</p>
    <p><strong>13.8 Appeals.</strong> If we decline to take action on your request, you may appeal our decision by replying to our response or emailing <a href="mailto:<?= e(EMAIL) ?>"><?= e(EMAIL) ?></a> with the subject line &ldquo;Privacy Request Appeal.&rdquo; We will respond to your appeal within the time required by applicable law.</p>
    <p><strong>13.9 Non-discrimination.</strong> We will not discriminate against you for exercising any of your privacy rights.</p>

    <h2>14. Children's Privacy</h2>
    <p>The Site is intended for adults and is not directed to children under the age of thirteen (13). We do not knowingly collect Personal Information from children under thirteen (13). If you believe that a child under thirteen (13) has provided Personal Information through the Site, please contact us and we will promptly delete it.</p>

    <h2>15. Third-Party Websites and Services</h2>
    <p>The Site may contain links to third-party websites and services, including review platforms and [financing partners]. These third parties operate independently and have their own privacy policies. We are not responsible for the content, privacy practices, or security of any third-party website or service. We encourage you to review the privacy policy of every website you visit.</p>

    <h2>16. Changes to This Policy</h2>
    <p>We may update this Policy from time to time to reflect changes in our practices, technologies, legal requirements, or other factors. When we make changes, we will update the &ldquo;Last Updated&rdquo; date at the top of this Policy. If we make material changes to how we use or disclose Personal Information previously collected, we will provide prominent notice on the Site before the change takes effect and, where required by law, obtain your consent. Your continued use of the Site after the effective date of an updated Policy constitutes acknowledgment of the updated Policy.</p>

    <h2>17. Governing Law</h2>
    <p>This Policy and any dispute arising out of or relating to it are governed by the laws of the State of Oklahoma and applicable federal law of the United States, without regard to conflict-of-law principles.</p>

    <h2>18. Contact Information</h2>
    <p>If you have questions, concerns, or requests regarding this Policy or our privacy practices, please contact us:</p>
    <p>
      <strong>Okie Heating and Cooling</strong><br>
      Tulsa, Oklahoma<br>
      Telephone: <?= e(OFFICE_PHONE_NUMBER) ?><br>
      Email: <a href="mailto:<?= e(EMAIL) ?>"><?= e(EMAIL) ?></a><br>
      Oklahoma Mechanical License No. <?= e(LICENSE_NUMBER) ?>
    </p>
  </div>
</section>

<?php require SITE_ROOT . '/includes/layout/footer.php'; ?>
