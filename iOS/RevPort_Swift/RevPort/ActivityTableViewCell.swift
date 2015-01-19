//
//  ActivityTableViewCell.swift
//  RevPort
//
//  Created by Odie Edo-Osagie on 19/01/2015.
//  Copyright (c) 2015 Odie Edo-Osagie. All rights reserved.
//

import UIKit

class ActivityTableViewCell: UITableViewCell {

    @IBOutlet weak var messageLabel: UILabel!
    @IBOutlet weak var timeLabel: UILabel!
    
    override func awakeFromNib() {
        super.awakeFromNib()
        // Initialization code
    }

    override func setSelected(selected: Bool, animated: Bool) {
        super.setSelected(selected, animated: animated)

        // Configure the view for the selected state
    }

}
