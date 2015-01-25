//
//  ModuleSelectTableViewController.swift
//  RevPort
//
//  Created by Odie Edo-Osagie on 22/01/2015.
//  Copyright (c) 2015 Odie Edo-Osagie. All rights reserved.
//

import UIKit

class ModuleSelectTableViewController: UITableViewController {

    /* Data SOurce */
    var modules = Array<PFObject>();
    
    /* Sub Views */
    var activityIndicator : UIActivityIndicatorView!;
    
    /* Others */
    var moduleToAdd : PFObject!;
    
    
    override func viewDidLoad() {
        super.viewDidLoad()

        /* Activity Indicator */
        activityIndicator = UIActivityIndicatorView(activityIndicatorStyle: UIActivityIndicatorViewStyle.Gray);
        activityIndicator.center = self.view.center;
        activityIndicator.hidesWhenStopped = true;
        self.view.addSubview(activityIndicator);
        activityIndicator.hidden = false;
        
        fetchModules();
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }

    // MARK: - Table view data source

    override func numberOfSectionsInTableView(tableView: UITableView) -> Int {
        // #warning Potentially incomplete method implementation.
        // Return the number of sections.
        return 1
    }

    override func tableView(tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        // #warning Incomplete method implementation.
        // Return the number of rows in the section.
        return self.modules.count;
    }

    
    override func tableView(tableView: UITableView, cellForRowAtIndexPath indexPath: NSIndexPath) -> UITableViewCell {
        let cell = tableView.dequeueReusableCellWithIdentifier("cell", forIndexPath: indexPath) as UITableViewCell
        var moduleCode = "";
        var moduleName = "";
        
        // Configure the cell...
        if(indexPath.row != self.modules.count){
            moduleCode = self.modules[indexPath.row]["moduleCode"] as String;
            moduleName = self.modules[indexPath.row]["moduleName"] as String;
        }
        
        cell.textLabel?.font = UIFont(name: "Code-Bold", size: 16.0);
        cell.textLabel?.textColor = AppUtils.sharedInstance.redColour1;
        cell.textLabel?.text = moduleName;
        
        cell.detailTextLabel?.font = UIFont(name: "JosefinSans-SemiBold", size: 16.0);
        cell.detailTextLabel?.text = moduleCode;
        
        
        return cell
    }
    
    override func tableView(tableView: UITableView, didSelectRowAtIndexPath indexPath: NSIndexPath) {
        moduleToAdd = self.modules[indexPath.row];
    }
    

    /*
    // Override to support conditional editing of the table view.
    override func tableView(tableView: UITableView, canEditRowAtIndexPath indexPath: NSIndexPath) -> Bool {
        // Return NO if you do not want the specified item to be editable.
        return true
    }
    */

    /*
    // Override to support editing the table view.
    override func tableView(tableView: UITableView, commitEditingStyle editingStyle: UITableViewCellEditingStyle, forRowAtIndexPath indexPath: NSIndexPath) {
        if editingStyle == .Delete {
            // Delete the row from the data source
            tableView.deleteRowsAtIndexPaths([indexPath], withRowAnimation: .Fade)
        } else if editingStyle == .Insert {
            // Create a new instance of the appropriate class, insert it into the array, and add a new row to the table view
        }    
    }
    */

    /*
    // Override to support rearranging the table view.
    override func tableView(tableView: UITableView, moveRowAtIndexPath fromIndexPath: NSIndexPath, toIndexPath: NSIndexPath) {

    }
    */

    /*
    // Override to support conditional rearranging of the table view.
    override func tableView(tableView: UITableView, canMoveRowAtIndexPath indexPath: NSIndexPath) -> Bool {
        // Return NO if you do not want the item to be re-orderable.
        return true
    }
    */
    
    
    // MARK: - Helper
    
    func fetchModules() {
        
        activityIndicator.startAnimating();
        
        var query = PFQuery(className:"Module");
        query.findObjectsInBackgroundWithBlock {
            (objects: [AnyObject]!, error: NSError!) -> Void in
            if error == nil {
                // The find succeeded.
                for object in objects {
                    var module : PFObject = object as PFObject;
                    self.modules.append(module);
                }
            } else {
                // Log details of the failure
                var errorInfo : [NSObject : AnyObject] = error!.userInfo!;
                var errorString : NSString = errorInfo["error"] as NSString;
                AppUtils.sharedInstance.makeAlertView("Error", message: errorString, action: "OK", sender: self);
            }
            
            self.tableView.reloadData();
            self.activityIndicator.stopAnimating();
        }
        
    }

    
    // MARK: - IBActions and Selectors
    @IBAction func doneButtonPressed(sender: AnyObject) {
        AppUtils.sharedInstance.storedModuleToAdd = moduleToAdd;
        NSNotificationCenter.defaultCenter().postNotificationName("DidSelectModuleToAdd", object: nil);
        self.dismissViewControllerAnimated(true, completion: nil);
    }
    
    
    override func prefersStatusBarHidden() -> Bool {
        return true;
    }
    
    /*
    // MARK: - Navigation

    // In a storyboard-based application, you will often want to do a little preparation before navigation
    override func prepareForSegue(segue: UIStoryboardSegue, sender: AnyObject?) {
        // Get the new view controller using [segue destinationViewController].
        // Pass the selected object to the new view controller.
    }
    */

}
