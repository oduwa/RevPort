//
//  ModuleTableViewController.swift
//  RevPort
//
//  Created by Odie Edo-Osagie on 19/01/2015.
//  Copyright (c) 2015 Odie Edo-Osagie. All rights reserved.
//

import UIKit

class ModuleTableViewController: UITableViewController {

    var modules = Array<PFObject>();
    var hasAddedNewModule : Bool = false;
    var moduleToShowTestsFor : PFObject!;
    
    override func viewDidLoad() {
        super.viewDidLoad()

        // Uncomment the following line to preserve selection between presentations
        // self.clearsSelectionOnViewWillAppear = false

        // Uncomment the following line to display an Edit button in the navigation bar for this view controller.
         self.navigationItem.rightBarButtonItem = self.editButtonItem()
        
        /* Nav Bar */
        self.navigationController?.navigationBar.topItem?.title = "Modules";
        
        /* Notifications */
        NSNotificationCenter.defaultCenter().addObserver(self, selector: Selector("addModuleRow"), name: "DidSelectModuleToAdd", object: nil);
    }

    override func viewDidAppear(animated: Bool) {
        super.viewDidAppear(animated);
        
        fetchModules();
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    

    // MARK: - Table view data source

    override func numberOfSectionsInTableView(tableView: UITableView) -> Int {
        // Return the number of sections.
        return 1
    }

    override func tableView(tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        // Return the number of rows in the section. plus one for insertion row
        return modules.count + 1;
    }

    
    override func tableView(tableView: UITableView, cellForRowAtIndexPath indexPath: NSIndexPath) -> UITableViewCell {
        let cell = tableView.dequeueReusableCellWithIdentifier("cell", forIndexPath: indexPath) as UITableViewCell
        var moduleCode = "";
        var moduleName = "";

        // Configure the cell...
        if(self.modules.count > 0){
            if(indexPath.row != self.modules.count){
                moduleCode = self.modules[indexPath.row]["moduleCode"] as String;
                moduleName = self.modules[indexPath.row]["moduleName"] as String;
            }
            
            cell.textLabel?.font = UIFont(name: "Code-Bold", size: 16.0);
            cell.textLabel?.textColor = AppUtils.sharedInstance.redColour1;
            cell.textLabel?.text = moduleName;
            
            cell.detailTextLabel?.font = UIFont(name: "JosefinSans-SemiBold", size: 16.0);
            //cell.detailTextLabel?.textColor = AppUtils.sharedInstance.turqoiseColour1;
            cell.detailTextLabel?.text = moduleCode;
        }
        

        return cell
    }
    
    override func tableView(tableView: UITableView, didSelectRowAtIndexPath indexPath: NSIndexPath) {
        if(indexPath.row != self.modules.count){
            moduleToShowTestsFor = self.modules[indexPath.row];
            self.performSegueWithIdentifier("showTests", sender: self);
        }
    }
    
    
    override func tableView(tableView: UITableView, editingStyleForRowAtIndexPath indexPath: NSIndexPath) -> UITableViewCellEditingStyle {
        
        if(indexPath.row == self.modules.count){
            return UITableViewCellEditingStyle.Insert
        }
        else{
            return UITableViewCellEditingStyle.Delete
        }
        
    }


    /*
    // Override to support conditional editing of the table view.
    override func tableView(tableView: UITableView, canEditRowAtIndexPath indexPath: NSIndexPath) -> Bool {
        // Return NO if you do not want the specified item to be editable.
        return true
    }
    */

    
    // Override to support editing the table view.
    override func tableView(tableView: UITableView, commitEditingStyle editingStyle: UITableViewCellEditingStyle, forRowAtIndexPath indexPath: NSIndexPath) {
        if editingStyle == .Delete {
            // Delete row from back end
            self.deleteModuleAtIndexFromBackEnd(indexPath);
            
            // Delete the row from the data source
            self.modules.removeAtIndex(indexPath.row)
            AppUtils.sharedInstance.cachedModules = self.modules;
            tableView.deleteRowsAtIndexPaths([indexPath], withRowAnimation: .Fade)
            
            // Flag activities view for updating
            AppUtils.sharedInstance.cachedActivities.removeAll(keepCapacity: false);
        } else if editingStyle == .Insert {
            // Create a new instance of the appropriate class, insert it into the array, and add a new row to the table view
            self.performSegueWithIdentifier("moduleSelectSegue", sender: self);
        }    
    }
    

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
        
        var currentUser = PFUser.currentUser();
        
        if(AppUtils.sharedInstance.cachedModules.isEmpty){
            // clear already loaded modules
            self.modules.removeAll(keepCapacity: false);
            
            // fetch users modules
            var relation = currentUser.relationForKey("modules");
            var query = relation.query();
            
            query.findObjectsInBackgroundWithBlock {
                (objects: [AnyObject]!, error: NSError!) -> Void in
                if(error == nil) {
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
                
                AppUtils.sharedInstance.cachedModules = self.modules;
                self.tableView.reloadData();
            }
        }
        else{
            self.modules = AppUtils.sharedInstance.cachedModules;
            self.tableView.reloadData();
        }
    }
    
    
    func deleteModuleAtIndexFromBackEnd(indexPath: NSIndexPath){
        
        /* Remove module from back-end */
        var currentUser = PFUser.currentUser();
        var moduleRelation = currentUser.relationForKey("modules");
        var moduleToRemove = self.modules[indexPath.row];
        moduleRelation.removeObject(moduleToRemove);
        
        
        /* Record activity */
        var newActivity = PFObject(className:"Activity");
        var modName = moduleToRemove["moduleName"] as String;
        var modCode = moduleToRemove["moduleCode"] as String;
        var activityMsg = "removed the module:  " + modCode + " - " + modName + ".";
        newActivity["activityMessage"] = activityMsg;
        newActivity.saveInBackgroundWithBlock { (succeeded, error) -> Void in
            if(succeeded){
                var activityRelation = currentUser.relationForKey("activities");
                activityRelation.addObject(newActivity);
                currentUser.saveEventually();
            }
            else{
                AppUtils.sharedInstance.makeAlertView("RevPort", message: "An error occured adding that module. Please try again later.", action: "OK", sender: self);
            }
        }

    }
    
    
    func addModuleToBackEnd(module : PFObject){
        
        /* Save module */
        var currentUser = PFUser.currentUser();
        var moduleRelation = currentUser.relationForKey("modules");
        moduleRelation.addObject(module);
        
        
        /* Save activity */
        var newActivity = PFObject(className:"Activity");
        var modName = module["moduleName"] as String;
        var modCode = module["moduleCode"] as String;
        var activityMsg = "added the module:  " + modCode + " - " + modName + ".";
        newActivity["activityMessage"] = activityMsg;
        newActivity.saveInBackgroundWithBlock { (succeeded, error) -> Void in
            if(succeeded){
                var activityRelation = currentUser.relationForKey("activities");
                activityRelation.addObject(newActivity);
                currentUser.saveEventually();
            }
            else{
                AppUtils.sharedInstance.makeAlertView("RevPort", message: "An error occured adding that module. Please try again later.", action: "OK", sender: self);
            }
        }
        
    }

    // MARK: - Selectors
    func addModuleRow(){
        
        /* Check that user addded a module */
        if(AppUtils.sharedInstance.storedModuleToAdd == nil){
            /* End editing */
            UIApplication.sharedApplication().sendAction(self.editButtonItem().action, to: self.editButtonItem().target, from: self, forEvent: nil);
            
            return;
        }
        
        
        /* Check that module has not already been added */
        var newModuleCode = AppUtils.sharedInstance.storedModuleToAdd["moduleCode"] as? String;
        for module in self.modules {
            var existingModuleCode = module["moduleCode"] as String;
            if(existingModuleCode == newModuleCode){
                return;
            }
        }
        
        
        /* If not already added, add new module to data source */
        self.modules.append(AppUtils.sharedInstance.storedModuleToAdd);
        AppUtils.sharedInstance.cachedModules = self.modules;
        self.tableView.reloadData();
        
        
        /* Save module to back end */
        addModuleToBackEnd(AppUtils.sharedInstance.storedModuleToAdd);
        
        
        /* End editing */
        UIApplication.sharedApplication().sendAction(self.editButtonItem().action, to: self.editButtonItem().target, from: self, forEvent: nil);
        
    }
    
    
    
    // MARK: - Navigation
    override func prepareForSegue(segue: UIStoryboardSegue, sender: AnyObject?) {
        // Get the new view controller using segue.destinationViewController.
        // Pass the selected object to the new view controller.
        
        if(segue.identifier == "showTests"){
            var testListCont = segue.destinationViewController as TestListTableViewController;
            testListCont.testModule = moduleToShowTestsFor;
        }
    }

}
