//
//  AppUtils.swift
//  RevPort
//
//  Created by Odie Edo-Osagie on 17/01/2015.
//  Copyright (c) 2015 Odie Edo-Osagie. All rights reserved.
//

import UIKit

private let _appUtilsSharedInstance = AppUtils();

class AppUtils: NSObject {
    
    var cachedActivities : Array<PFObject> = Array<PFObject>();
    var cachedModules : Array<PFObject> = Array<PFObject>();
    var storedModuleToAdd : PFObject!;
    var storedQuestions : Array<PFObject> = Array<PFObject>();

    
    class var sharedInstance: AppUtils {
        return _appUtilsSharedInstance;
    }
    
    func makeAlertView(title: String, message: String, action: String, sender: UIViewController) -> Void {

        if objc_getClass("UIAlertController") != nil{
            var alert = UIAlertController(title: title, message: message, preferredStyle: UIAlertControllerStyle.Alert)
            alert.addAction(UIAlertAction(title: action, style: UIAlertActionStyle.Default, handler:nil))
            sender.presentViewController(alert, animated: true, completion: nil)
        }
        else {
            var alert = UIAlertView(title: title, message: message, delegate: sender, cancelButtonTitle:action)
            alert.show()
        }
        
    }
    
    func makeAlertView(title: String, message: String, action: String, sender: UIViewController, actionBlock: ((UIAlertAction!) -> Void)!) -> Void {
        
        if objc_getClass("UIAlertController") != nil {
            var alert = UIAlertController(title: title, message: message, preferredStyle: UIAlertControllerStyle.Alert)
            alert.addAction(UIAlertAction(title: "Cancel", style: UIAlertActionStyle.Cancel, handler:nil))
            alert.addAction(UIAlertAction(title: action, style: UIAlertActionStyle.Default, handler:actionBlock));
            sender.presentViewController(alert, animated: true, completion: nil)
        }
        else {
            var alert = UIAlertView(title: title, message: message, delegate: sender, cancelButtonTitle:"Cancel")
            alert.addButtonWithTitle(action);
            alert.show()
        }
        
    }
    
    func clearCachedProperties() -> Void {
        
        _appUtilsSharedInstance.cachedActivities.removeAll(keepCapacity: false);
        _appUtilsSharedInstance.cachedModules.removeAll(keepCapacity: false);
        
    }
    
    func roundToDecimalPlaces(value : Double, decimalPlaces : Int) -> Double{

        var multiplier = pow(10.0, Double(decimalPlaces));
        var result = round(value * multiplier) / multiplier
        return result;
        
    }
    
    
    
}
