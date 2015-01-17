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

    
    class var sharedInstance: AppUtils {
        return _appUtilsSharedInstance;
    }
    
    func makeAlertView(title: String, message: String, action: String, sender: UIViewController) -> Void {

        if respondsToSelector("UIAlertController"){
            var alert = UIAlertController(title: title, message: message, preferredStyle: UIAlertControllerStyle.Alert)
            alert.addAction(UIAlertAction(title: action, style: UIAlertActionStyle.Default, handler:nil))
            sender.presentViewController(alert, animated: true, completion: nil)
        }
        else {
            var alert = UIAlertView(title: title, message: message, delegate: sender, cancelButtonTitle:action)
            alert.show()
        }
        
    }
    
    
    
}
