//
//  SignupViewController.swift
//  RevPort
//
//  Created by Odie Edo-Osagie on 17/01/2015.
//  Copyright (c) 2015 Odie Edo-Osagie. All rights reserved.
//

import UIKit

class SignupViewController: UIViewController, UITextFieldDelegate {

    @IBOutlet weak var emailTextField: UITextField!
    @IBOutlet weak var firstNameTextField: UITextField!
    @IBOutlet weak var lastNameTextField: UITextField!
    @IBOutlet weak var usernameTextField: UITextField!
    @IBOutlet weak var passwordTextField: UITextField!
    
    @IBOutlet weak var scrollView: TPKeyboardAvoidingScrollView!
    @IBOutlet weak var emailTopConstraint: NSLayoutConstraint!
    
    var activityIndicator : UIActivityIndicatorView!;
    
    var keyboardShowing : Bool = false;
    var fieldsNeedMoving : Bool = false;
    var offset : CGFloat = 0.0;
    
    
    override func viewDidLoad() {
        super.viewDidLoad()

        /* Make nav bar COMPLETELY transparent */
        self.navigationController?.navigationBar.setBackgroundImage(UIImage(), forBarMetrics: UIBarMetrics.Default);
        self.navigationController?.navigationBar.shadowImage = UIImage();
        self.navigationController?.navigationBar.translucent = true;
        
        
        /* Email Text field */
        //emailTextField.borderStyle = UITextBorderStyle.None;
        //emailTextField.attributedPlaceholder = NSAttributedString(string:"email", attributes:[NSForegroundColorAttributeName: UIColor.whiteColor()]);
        emailTextField.delegate = self;
        
        /* First Name Text Field */
        //firstNameTextField.borderStyle = UITextBorderStyle.None;
        //firstNameTextField.attributedPlaceholder = NSAttributedString(string:"first name", attributes:[NSForegroundColorAttributeName: UIColor.whiteColor()]);
        firstNameTextField.delegate = self;
        
        /* Last Name Text Field */
        //lastNameTextField.borderStyle = UITextBorderStyle.None;
        //lastNameTextField.attributedPlaceholder = NSAttributedString(string:"last name", attributes:[NSForegroundColorAttributeName: UIColor.whiteColor()]);
        lastNameTextField.delegate = self;
        
        /* Username Text field */
        //usernameTextField.borderStyle = UITextBorderStyle.None;
        //usernameTextField.attributedPlaceholder = NSAttributedString(string:"username", attributes:[NSForegroundColorAttributeName: UIColor.whiteColor()]);
        usernameTextField.delegate = self;
        
        /* Password Text Field */
        //passwordTextField.borderStyle = UITextBorderStyle.None;
        //passwordTextField.attributedPlaceholder = NSAttributedString(string:"password", attributes:[NSForegroundColorAttributeName: UIColor.whiteColor()]);
        passwordTextField.delegate = self;
        
        /* Keyboard Handling */
        //self.registerForKeyboardNotifications();
        
        
        /* Activity Indicator */
        activityIndicator = UIActivityIndicatorView(activityIndicatorStyle: UIActivityIndicatorViewStyle.WhiteLarge);
        activityIndicator.center = self.view.center;
        activityIndicator.hidesWhenStopped = true;
        self.view.addSubview(activityIndicator);
    
    }
    
    override func viewDidAppear(animated: Bool) {
        super.viewDidAppear(animated);
        
        /* Scroll to bottom of scroll view */
        var bottomOffset = CGPointMake(0, self.scrollView.contentSize.height - self.scrollView.bounds.size.height);
        self.scrollView.setContentOffset(bottomOffset, animated: true);
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    

    // MARK: - Keyboard Handling
    func registerForKeyboardNotifications() -> Void {
        NSNotificationCenter.defaultCenter().addObserver(self, selector: "keyboardWasShown:", name: UIKeyboardWillShowNotification, object: nil);
        NSNotificationCenter.defaultCenter().addObserver(self, selector: "keyboardWasHidden:", name: UIKeyboardWillHideNotification, object: nil);
    }
    
    func freeKeyboardNotifications() -> Void {
        NSNotificationCenter.defaultCenter().removeObserver(self, name: UIKeyboardWillShowNotification, object: nil);
        NSNotificationCenter.defaultCenter().removeObserver(self, name: UIKeyboardWillHideNotification, object: nil);
    }
    
    func keyboardWasShown(notification:NSNotification) -> Void {
        if(!keyboardShowing){
            var notificationInfo : [NSObject : AnyObject] = notification.userInfo!;
            
            var keyboardFrameValue : NSValue = notificationInfo[UIKeyboardFrameEndUserInfoKey] as! NSValue;
            var animationDuration : NSTimeInterval = notificationInfo[UIKeyboardAnimationDurationUserInfoKey] as! NSTimeInterval;
            var keyboardFrame : CGRect = keyboardFrameValue.CGRectValue();
            
            var isPortrait : Bool = UIApplication.sharedApplication().statusBarOrientation.isPortrait;
            var keyboardHeight : CGFloat = isPortrait ? keyboardFrame.size.height : keyboardFrame.size.width;
            
            /* Updating Constraints */
            offset = self.emailTextField.frame.origin.y - (keyboardHeight - self.firstNameTextField.frame.size.height - self.lastNameTextField.frame.size.height - self.usernameTextField.frame.size.height - self.passwordTextField.frame.size.height - 35);
            
            // Only move if keyboard will obstruct text fields
            if((screenSize.height - self.emailTextField.frame.origin.y) < (keyboardHeight + self.firstNameTextField.frame.size.height + self.lastNameTextField.frame.size.height + self.usernameTextField.frame.size.height + self.passwordTextField.frame.size.height + 15)){
                fieldsNeedMoving = true;
                //println(self.usernameTopConstraint.constant);
                self.emailTopConstraint.constant -= offset;
            }
            keyboardShowing = true;
            println(offset);
            
            UIView.animateWithDuration(animationDuration, animations: { () -> Void in
                self.view.layoutIfNeeded();
            });
        }
    }
    
    func keyboardWasHidden(notification:NSNotification) -> Void {
        if(keyboardShowing){
            var notificationInfo : [NSObject : AnyObject] = notification.userInfo!;
            
            var keyboardFrameValue : NSValue = notificationInfo[UIKeyboardFrameEndUserInfoKey] as! NSValue;
            var animationDuration : NSTimeInterval = notificationInfo[UIKeyboardAnimationDurationUserInfoKey] as! NSTimeInterval;
            var keyboardFrame : CGRect = keyboardFrameValue.CGRectValue();
            
            var isPortrait : Bool = UIApplication.sharedApplication().statusBarOrientation.isPortrait;
            var keyboardHeight : CGFloat = isPortrait ? keyboardFrame.size.height : keyboardFrame.size.width;
            //println("KB HEIGHT: " + keyboardHeight);
            
            /* Updating Constraints */
            // Only move if keyboard will obstruct text fields
            if(fieldsNeedMoving){
                self.emailTopConstraint.constant += offset;
            }
            keyboardShowing = false;
            
            UIView.animateWithDuration(animationDuration, animations: { () -> Void in
                self.view.layoutIfNeeded();
            });
        }
    }
    
    
    // MARK: - UITextField Delegate
    func textFieldShouldReturn(textField: UITextField) -> Bool {
        
        /* If "Go" is pressed on password keyboard signup, else just hide keyboard */
        
        if(textField == passwordTextField){
            
            var email : String = emailTextField.text.stringByTrimmingCharactersInSet(NSCharacterSet.whitespaceAndNewlineCharacterSet());
            var firstName : String = firstNameTextField.text.stringByTrimmingCharactersInSet(NSCharacterSet.whitespaceAndNewlineCharacterSet());
            var lastName : String = lastNameTextField.text.stringByTrimmingCharactersInSet(NSCharacterSet.whitespaceAndNewlineCharacterSet());
            var username : String = usernameTextField.text.stringByTrimmingCharactersInSet(NSCharacterSet.whitespaceAndNewlineCharacterSet());
            var password : String = passwordTextField.text.stringByTrimmingCharactersInSet(NSCharacterSet.whitespaceAndNewlineCharacterSet());
            
            /* Check that all fields were completed */
            if(!email.isEmpty && !firstName.isEmpty && !lastName.isEmpty && !username.isEmpty && !password.isEmpty){
                
                /* Sign up */
                var user = PFUser();
                user.username = username;
                user.password = password;
                user.email = email;
                user["firstName"] = firstName;
                user["lastName"] = lastName;
                
                activityIndicator.startAnimating();
                user.signUpInBackgroundWithBlock({ (succeeded, error) -> Void in
                    self.activityIndicator.stopAnimating();
                    
                    if(succeeded == true){
                        // let them use the app
                        self.navigationController?.popToRootViewControllerAnimated(true);
                    }
                    else{
                        var errorInfo : [NSObject : AnyObject] = error!.userInfo!;
                        var errorString : NSString = errorInfo["error"] as! NSString;
                        AppUtils.sharedInstance.makeAlertView("Error", message: errorString as String, action: "OK", sender: self);
                    }
                })
            }
            else{
                AppUtils.sharedInstance.makeAlertView("", message: "Please complete all fields before you continue", action: "OK", sender: self);
            }
            
        }
        else{
            
        }
        return textField.resignFirstResponder();
    }
    
    /*
    // MARK: - Navigation

    // In a storyboard-based application, you will often want to do a little preparation before navigation
    override func prepareForSegue(segue: UIStoryboardSegue, sender: AnyObject?) {
        // Get the new view controller using segue.destinationViewController.
        // Pass the selected object to the new view controller.
    }
    */

}
