//
//  ActivityTableViewController.swift
//  RevPort
//
//  Created by Odie Edo-Osagie on 17/01/2015.
//  Copyright (c) 2015 Odie Edo-Osagie. All rights reserved.
//

import UIKit

class ActivityTableViewController: UITableViewController {

    var activities = Array<PFObject>();
    
    // MARK: - View Lifecycle
    override func viewDidLoad() {
        super.viewDidLoad()

        // Uncomment the following line to preserve selection between presentations
        // self.clearsSelectionOnViewWillAppear = false

        // Uncomment the following line to display an Edit button in the navigation bar for this view controller.
        // self.navigationItem.rightBarButtonItem = self.editButtonItem()
        
        var currentUser = PFUser.currentUser();
    
        if(currentUser == nil){
            self.performSegueWithIdentifier("showLogin", sender: self);
        }
        else{
            //PFUser.logOut();
        }
    }
    
    override func viewWillAppear(animated: Bool) {
        super.viewWillAppear(animated);
        
        /* Show Tab bar */
        self.tabBarController?.tabBar.hidden = false;
        
        /* Make nav bar translucent rather than transparent */
        self.navigationController?.navigationBar.setBackgroundImage(nil, forBarMetrics: UIBarMetrics.Default);
        self.navigationController?.navigationBar.shadowImage = nil;
        self.navigationController?.navigationBar.translucent = true;
        
        var currentUser = PFUser.currentUser();
        if(currentUser != nil && AppUtils.sharedInstance.cachedActivities.isEmpty){
            // fetch users activities
            var relation = currentUser.relationForKey("activities");
            var query = relation.query();
            query.limit = 20;
            
            query.findObjectsInBackgroundWithBlock {
                (objects: [AnyObject]!, error: NSError!) -> Void in
                if(error == nil) {
                    for object in objects {
                        var activity : PFObject = object as PFObject;
                        self.activities.append(activity);
                    }
                } else {
                    // Log details of the failure
                    NSLog("Error: %@ %@", error, error.userInfo!)
                }
                
                AppUtils.sharedInstance.cachedActivities = self.activities;
                self.tableView.reloadData();
            }
        }
        else{
            self.activities = AppUtils.sharedInstance.cachedActivities;
            self.tableView.reloadData();
        }
        
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }

    
    
    
    // MARK: - Table view data source
    override func numberOfSectionsInTableView(tableView: UITableView) -> Int {
        // #warning Potentially incomplete method implementation.
        // Return the number of sections.
        return 1;
    }

    override func tableView(tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        // #warning Incomplete method implementation.
        // Return the number of rows in the section.
        return self.activities.count;
    }

    
    override func tableView(tableView: UITableView, cellForRowAtIndexPath indexPath: NSIndexPath) -> UITableViewCell {
        let cell = tableView.dequeueReusableCellWithIdentifier("cell", forIndexPath: indexPath) as UITableViewCell

        // Configure the cell...
        var activityMessage = self.activities[indexPath.row]["activityMessage"] as String;
        cell.textLabel?.text = activityMessage;
        cell.textLabel?.numberOfLines = 0

        return cell
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

    
    
    
    
    // MARK: - Navigation
    
    // In a storyboard-based application, you will often want to do a little preparation before navigation
    override func prepareForSegue(segue: UIStoryboardSegue, sender: AnyObject?) {
        // Get the new view controller using segue.destinationViewController.
        // Pass the selected object to the new view controller.
        
        if(segue.identifier == "showLogin"){
            self.tabBarController?.tabBar.hidden = true;
        }
    }

}
