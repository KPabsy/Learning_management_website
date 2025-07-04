</div>
    </main>
    
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Contact Information</h3>
                    <p><strong>Ashan Sudusingha</strong></p>
                    <ul>
                       <li>Our Address:Joink Waththa,Kelaniya</li> 
                    <li>Email: ashansudusingha@gmail.com</li><p></p>
                    <li>Phone: +94 77 123 4567</li><p></p>
                  </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Class Schedule</h3>
                    <ul>
                   <li>Monday & Wednesday: 4:00 PM - 6:00 PM</li> 
                   <li>Tuesday & Thursday: 4:00 PM - 6:00 PM</li> 
                   <li>Saturday: 2:00 PM - 5:00 PM</li> 
                 </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Location</h3>
                    <ul>
                  <li>SySyGy-GAMPAHA</li>  
                  <li>SISULKA-NUGEGODA</li> 
                  <li>Home Based</li>  
              </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    <style>
        footer {
            background-color: #2c3e50;
            color: white;
            padding: 30px 0 20px;
            margin-top: 40px;
        }
        
        .footer-content {
            display: flex;
            justify-content: space-between;
            gap: 30px;
            margin-bottom: 20px;
        }
        
        .footer-section {
            flex: 1;
        }
        
        .footer-section h3 {
            color:rgba(250, 240, 240, 0.44);
            margin-bottom: 10px;
            font-size: 1.4rem;
            font-weight:bold;
            font-family: "Times New Roman", Times, serif;
        }
        
        .footer-section p {
            margin-bottom: 5px;
            font-size: 0.9rem;
            line-height: 1.4;
        }

        .footer-section ul{
            list-style: none;
        }
        
        .footer-bottom {
            border-top: 1px solid #34495e;
            padding-top: 15px;
            text-align: center;
        }
        
        .footer-bottom p {
            margin-bottom: 5px;
            font-size: 0.8rem;
            color: #bdc3c7;
        }
        
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 15px;
            }
            
            nav ul {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .footer-content {
                flex-direction: column;
                gap: 20px;
            }
            
            .user-info {
                text-align: center;
            }
        }
    </style>
</body>
</html>