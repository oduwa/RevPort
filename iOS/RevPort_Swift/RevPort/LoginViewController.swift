//
//  LoginViewController.swift
//  RevPort
//
//  Created by Odie Edo-Osagie on 17/01/2015.
//  Copyright (c) 2015 Odie Edo-Osagie. All rights reserved.
//

import UIKit

let screenSize: CGRect = UIScreen.mainScreen().bounds;

class LoginViewController: UIViewController {

    @IBOutlet weak var usernameTextField: UITextField!
    @IBOutlet weak var passwordTextField: UITextField!

    @IBOutlet weak var usernameTopConstraint: NSLayoutConstraint!
    
    var keyboardShowing : Bool = false;
    var fieldsNeedMoving : Bool = false;
    var offset : CGFloat = 0.0;
    

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
            
            var keyboardFrameValue : NSValue = notificationInfo[UIKeyboardFrameEndUserInfoKey] as NSValue;
            var animationDuration : NSTimeInterval = notificationInfo[UIKeyboardAnimationDurationUserInfoKey] as NSTimeInterval;
            var keyboardFrame : CGRect = keyboardFrameValue.CGRectValue();
            
            var isPortrait : Bool = UIApplication.sharedApplication().statusBarOrientation.isPortrait;
            var keyboardHeight : CGFloat = isPortrait ? keyboardFrame.size.height : keyboardFrame.size.width;
            
            /* Updating Constraints */
            offset = self.usernameTextField.frame.origin.y - (keyboardHeight - self.passwordTextField.frame.size.height);
            
            // Only move if keyboard will obstruct text fields
            if((screenSize.height - self.usernameTextField.frame.origin.y) < (keyboardHeight + self.passwordTextField.frame.size.height)){
                fieldsNeedMoving = true;
                self.usernameTopConstraint.constant -= offset;
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
            
            var keyboardFrameValue : NSValue = notificationInfo[UIKeyboardFrameEndUserInfoKey] as NSValue;
            var animationDuration : NSTimeInterval = notificationInfo[UIKeyboardAnimationDurationUserInfoKey] as NSTimeInterval;
            var keyboardFrame : CGRect = keyboardFrameValue.CGRectValue();
            
            var isPortrait : Bool = UIApplication.sharedApplication().statusBarOrientation.isPortrait;
            var keyboardHeight : CGFloat = isPortrait ? keyboardFrame.size.height : keyboardFrame.size.width;
            //println("KB HEIGHT: " + keyboardHeight);
            
            /* Updating Constraints */
            // Only move if keyboard will obstruct text fields
            if(fieldsNeedMoving){
                self.usernameTopConstraint.constant += offset;
            }
            keyboardShowing = false;
            
            UIView.animateWithDuration(animationDuration, animations: { () -> Void in
                self.view.layoutIfNeeded();
            });
        }
    }
    
    
    // MARK: - View Lifecycle
    override func viewDidLoad() {
        super.viewDidLoad()

        // Do any additional setup after loading the view.
        
        /* Username Text field */
        usernameTextField.borderStyle = UITextBorderStyle.None;
        usernameTextField.attributedPlaceholder = NSAttributedString(string:"username",
            attributes:[NSForegroundColorAttributeName: UIColor.whiteColor()]);
        
        /* Password Text Field */
        passwordTextField.borderStyle = UITextBorderStyle.None;
        passwordTextField.attributedPlaceholder = NSAttributedString(string:"password",
            attributes:[NSForegroundColorAttributeName: UIColor.whiteColor()]);
        
        /* Make nav bar COMPLETELY transparent */
        self.navigationController?.navigationBar.setBackgroundImage(UIImage(), forBarMetrics: UIBarMetrics.Default);
        self.navigationController?.navigationBar.shadowImage = UIImage();
        self.navigationController?.navigationBar.translucent = true;
        
        /* Keyboard Handling */
        self.registerForKeyboardNotifications();
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    

    // MARK: - IBActions
    @IBAction func usernameFieldReturn(sender: AnyObject) {
        var textField = sender as UITextField;
        textField.resignFirstResponder();
    }
    
    @IBAction func passwordFieldReturn(sender: AnyObject) {
        var textField = sender as UITextField;
        textField.resignFirstResponder();
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
